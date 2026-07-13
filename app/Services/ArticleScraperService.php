<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Mengambil judul, gambar utama, dan cuplikan teks dari sebuah URL publik
 * untuk dijadikan TITIK AWAL draf artikel — bukan untuk dipublikasikan mentah-mentah.
 *
 * PENTING (hak cipta): konten dari situs lain adalah milik pemilik situs asal.
 * Hasil scrape di sini WAJIB ditulis ulang dengan kalimat sendiri oleh admin
 * sebelum status artikel diubah menjadi "published". UI admin menampilkan
 * peringatan ini setiap kali fitur scrape dipakai.
 */
class ArticleScraperService
{
    public function scrape(string $url): array
    {
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (compatible; MalangkabBot/1.0; +https://malangkab.com)',
        ])->timeout(15)->get($url);

        if (! $response->successful()) {
            throw new \RuntimeException('Gagal mengambil halaman: HTTP '.$response->status());
        }

        $html = $response->body();

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>'.$html);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);

        $title = $this->firstMeta($xpath, [
            '//meta[@property="og:title"]/@content',
            '//title',
        ]) ?? 'Judul tidak ditemukan';

        $image = $this->firstMeta($xpath, [
            '//meta[@property="og:image"]/@content',
        ]);

        $description = $this->firstMeta($xpath, [
            '//meta[@property="og:description"]/@content',
            '//meta[@name="description"]/@content',
        ]) ?? '';

        // Ambil teks kasar dari tag <article> atau <p> sebagai bahan mentah (bukan hasil akhir).
        $paragraphs = [];
        foreach ($xpath->query('//article//p | //p') as $node) {
            $text = trim($node->textContent);
            if (mb_strlen($text) > 40) {
                $paragraphs[] = $text;
            }
            if (count($paragraphs) >= 8) {
                break;
            }
        }

        return [
            'source_url' => $url,
            'title' => trim(strip_tags($title)),
            'excerpt' => Str::limit(trim($description), 160),
            'image' => $image,
            'raw_paragraphs' => $paragraphs,
            'notice' => 'Ini konten mentah hasil scrape dari sumber lain. Tulis ulang dengan kalimat sendiri sebelum dipublikasikan, dan cantumkan sumber jika mengutip fakta.',
        ];
    }

    private function firstMeta(DOMXPath $xpath, array $queries): ?string
    {
        foreach ($queries as $query) {
            $nodes = $xpath->query($query);
            if ($nodes && $nodes->length > 0) {
                $node = $nodes->item(0);
                $value = $node->nodeValue ?? null;
                if ($value) {
                    return $value;
                }
            }
        }

        return null;
    }
}
