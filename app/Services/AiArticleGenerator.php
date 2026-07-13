<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Generate draf artikel (judul, excerpt, isi HTML) memakai Claude API.
 *
 * Perlu di .env:
 *   ANTHROPIC_API_KEY=sk-ant-xxxx
 *   ANTHROPIC_MODEL=claude-sonnet-5   (opsional, cek nama model terbaru di docs.claude.com)
 *
 * Hasil generate SELALU disimpan sebagai draft (status=draft) — admin wajib
 * membaca & menyunting sebelum dipublikasikan, terutama untuk data faktual
 * (nama tempat, angka, sejarah) yang harus diverifikasi manual.
 */
class AiArticleGenerator
{
    public function generate(string $topic, string $categoryLabel, ?string $extraContext = null): array
    {
        $apiKey = config('services.anthropic.key');
        $model = config('services.anthropic.model', 'claude-sonnet-5');

        if (! $apiKey) {
            throw new \RuntimeException('ANTHROPIC_API_KEY belum diisi di .env');
        }

        $prompt = <<<PROMPT
        Kamu membantu tim redaksi situs profil daerah malangkab.com menulis draf artikel
        untuk kategori "{$categoryLabel}" dengan topik: "{$topic}".
        {$extraContext}

        Tulis dalam Bahasa Indonesia, gaya ensiklopedis-informatif, netral, tidak berlebihan.
        Jangan mengarang angka statistik atau klaim spesifik yang tidak bisa dipastikan;
        gunakan bahasa umum ("salah satu", "dikenal dengan") bila tidak yakin akan detail.

        Balas HANYA dengan JSON valid, tanpa teks lain, format persis:
        {
          "title": "...",
          "excerpt": "... (maks 160 karakter)",
          "body_html": "<p>...</p><p>...</p>"
        }
        PROMPT;

        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
            'anthropic-version' => '2023-06-01',
            'content-type' => 'application/json',
        ])->timeout(60)->post('https://api.anthropic.com/v1/messages', [
            'model' => $model,
            'max_tokens' => 1200,
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        if (! $response->successful()) {
            throw new \RuntimeException('Gagal memanggil Claude API: '.$response->body());
        }

        $text = collect($response->json('content'))
            ->firstWhere('type', 'text')['text'] ?? '{}';

        $clean = trim(preg_replace('/```json|```/', '', $text));
        $data = json_decode($clean, true);

        if (! is_array($data) || empty($data['title'])) {
            throw new \RuntimeException('Respons AI tidak sesuai format JSON yang diharapkan.');
        }

        return [
            'title' => $data['title'],
            'excerpt' => $data['excerpt'] ?? '',
            'body' => $data['body_html'] ?? '',
            'notice' => 'Draf hasil AI. Wajib dibaca ulang dan diverifikasi faktanya sebelum dipublikasikan.',
        ];
    }
}
