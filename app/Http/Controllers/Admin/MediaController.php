<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    private const MAX_BYTES = 8 * 1024 * 1024; // 8MB per gambar
    private const ALLOWED_EXT = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

    /**
     * Upload file langsung dari komputer admin (bisa lebih dari satu sekaligus
     * untuk galeri). Disimpan ke storage/app/public/uploads, diakses lewat
     * /storage/uploads/... (pastikan sudah jalankan `php artisan storage:link`).
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'files' => ['required', 'array', 'min:1', 'max:20'],
            'files.*' => ['file', 'image', 'max:8192', 'mimes:'.implode(',', self::ALLOWED_EXT)],
        ]);

        $urls = [];

        foreach ($request->file('files') as $file) {
            $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('uploads', $filename, 'public');
            $urls[] = Storage::url($path);
        }

        return response()->json(['ok' => true, 'urls' => $urls]);
    }

    /**
     * Unduh gambar dari satu atau beberapa URL (satu per baris) ke server,
     * lalu simpan lokal -- supaya situs TIDAK hotlink ke server orang lain.
     *
     * PENTING (hak cipta): mengunduh gambar dari URL tidak otomatis memberi
     * hak pakai. Pastikan Anda memang berhak memakai gambar tersebut (milik
     * sendiri, berlisensi bebas seperti Wikimedia Commons, atau sudah dapat
     * izin) sebelum menempelkannya di sini.
     */
    public function fetchUrls(Request $request): JsonResponse
    {
        $request->validate([
            'urls' => ['required', 'string'],
        ]);

        $lines = collect(preg_split('/\r\n|\r|\n/', $request->string('urls')))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->take(20);

        $urls = [];
        $errors = [];

        foreach ($lines as $line) {
            try {
                if (! filter_var($line, FILTER_VALIDATE_URL)) {
                    throw new \RuntimeException('URL tidak valid.');
                }

                $response = Http::timeout(15)->get($line);

                if (! $response->successful()) {
                    throw new \RuntimeException('Gagal diunduh (HTTP '.$response->status().').');
                }

                $contentType = $response->header('Content-Type', '');
                if (! str_starts_with($contentType, 'image/')) {
                    throw new \RuntimeException('Bukan file gambar (Content-Type: '.$contentType.').');
                }

                $body = $response->body();
                if (strlen($body) > self::MAX_BYTES) {
                    throw new \RuntimeException('Ukuran file lebih dari 8MB.');
                }

                $ext = match (true) {
                    str_contains($contentType, 'png') => 'png',
                    str_contains($contentType, 'webp') => 'webp',
                    str_contains($contentType, 'gif') => 'gif',
                    default => 'jpg',
                };

                $filename = 'uploads/'.Str::uuid().'.'.$ext;
                Storage::disk('public')->put($filename, $body);

                $urls[] = Storage::url($filename);
            } catch (\Throwable $e) {
                $errors[] = "{$line}: {$e->getMessage()}";
            }
        }

        return response()->json(['ok' => true, 'urls' => $urls, 'errors' => $errors]);
    }
}
