<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SmpNegeri1ArticleSeeder extends Seeder
{
    /**
     * Untuk tiap kategori sekolah 'SMP Negeri 1 [Kecamatan]' (dibuat oleh
     * PendidikanCategorySeeder), seeder ini membuat 4 artikel TEMPLATE:
     * Profil, Statistik (Dapodik), Prestasi, dan Kontak Person.
     *
     * PENTING: isinya adalah KERANGKA/TEMPLATE, BUKAN data faktual asli.
     * Saya sengaja TIDAK mengarang alamat lengkap, jumlah siswa/guru, daftar
     * prestasi, atau nomor kontak -- karena ini sekolah negeri sungguhan dan
     * menyajikan angka palsu sebagai fakta akan menyesatkan. Semua artikel
     * berstatus 'draft'. Admin WAJIB melengkapi lewat panel admin sebelum
     * publish, idealnya dengan data resmi dari:
     * - Statistik: https://dapo.kemdikbud.go.id (cari NPSN sekolah)
     * - Profil & kontak: konfirmasi langsung ke pihak sekolah
     * - Galeri: foto resmi dari sekolah (bukan hasil scrape/Google Images,
     *   demi menghindari masalah hak cipta -- lihat catatan galeri di README)
     */
    public function run(): void
    {
        foreach ($this->kecamatan() as $nama) {
            $schoolName = 'SMP Negeri 1 '.$nama;
            $schoolSlug = Str::slug($schoolName);
            $category = Category::where('slug', $schoolSlug)->first();

            if (! $category) {
                continue; // jalankan PendidikanCategorySeeder dulu
            }

            foreach ($this->articleTemplates($schoolName, $nama) as $item) {
                $slug = Str::slug($schoolSlug.'-'.$item['type']);

                Article::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'category_id' => $category->id,
                        'title' => $item['title'],
                        'excerpt' => $item['excerpt'],
                        'body' => $item['body'],
                        'cover_image' => 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0MDAgMjYwIj4KPHJlY3Qgd2lkdGg9IjQwMCIgaGVpZ2h0PSIyNjAiIGZpbGw9IiNFRkU5REMiLz4KPHJlY3QgeD0iNjAiIHk9IjEyMCIgd2lkdGg9IjI4MCIgaGVpZ2h0PSIxMTAiIGZpbGw9IiNBODUzMzMiLz4KPHBvbHlnb24gcG9pbnRzPSI2MCwxMjAgMjAwLDYwIDM0MCwxMjAiIGZpbGw9IiMyRjRBMzQiLz4KPHJlY3QgeD0iMTg1IiB5PSIxNjAiIHdpZHRoPSIzMCIgaGVpZ2h0PSI3MCIgZmlsbD0iI0YzRUNERCIvPgo8cmVjdCB4PSI5MCIgeT0iMTUwIiB3aWR0aD0iMzUiIGhlaWdodD0iMzUiIGZpbGw9IiNGM0VDREQiLz4KPHJlY3QgeD0iMjc1IiB5PSIxNTAiIHdpZHRoPSIzNSIgaGVpZ2h0PSIzNSIgZmlsbD0iI0YzRUNERCIvPgo8cmVjdCB4PSIxOTAiIHk9IjU1IiB3aWR0aD0iOCIgaGVpZ2h0PSIyNSIgZmlsbD0iIzJGNEEzNCIvPgo8Y2lyY2xlIGN4PSIxOTQiIGN5PSI1MCIgcj0iNiIgZmlsbD0iI0M5OEEyQyIvPgo8dGV4dCB4PSIyMDAiIHk9IjI1MCIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZm9udC1mYW1pbHk9Ikdlb3JnaWEsIHNlcmlmIiBmb250LXNpemU9IjE2IiBmaWxsPSIjM0I0QTU0Ij5TTVAgTmVnZXJpPC90ZXh0Pgo8L3N2Zz4=',
                        'gallery' => [],
                        'meta' => ['jenis' => $item['type'], 'kecamatan' => $nama],
                        'status' => 'draft',
                        'published_at' => null,
                    ]
                );
            }
        }
    }

    private function articleTemplates(string $schoolName, string $kecamatan): array
    {
        $disclaimer = '<p><em>Catatan: bagian ini masih berupa template dan perlu dilengkapi admin '
            .'dengan data resmi sebelum dipublikasikan.</em></p>';

        return [
            [
                'type' => 'profil',
                'title' => "Profil {$schoolName}",
                'excerpt' => "Profil {$schoolName}, Kecamatan {$kecamatan}, Kabupaten Malang.",
                'body' => "<p><strong>Nama Sekolah:</strong> {$schoolName}</p>"
                    ."<p><strong>Jenjang:</strong> Sekolah Menengah Pertama (SMP)</p>"
                    ."<p><strong>Status:</strong> Negeri</p>"
                    ."<p><strong>Kecamatan:</strong> {$kecamatan}, Kabupaten Malang</p>"
                    .'<p><strong>Alamat lengkap:</strong> - (perlu dilengkapi admin)</p>'
                    .'<p><strong>NPSN:</strong> - (cek di https://dapo.kemdikbud.go.id)</p>'
                    .'<p><strong>Akreditasi:</strong> - (perlu dilengkapi admin)</p>'
                    .'<p><strong>Kepala Sekolah:</strong> - (perlu dilengkapi admin)</p>'
                    .$disclaimer,
            ],
            [
                'type' => 'statistik',
                'title' => "Statistik {$schoolName}",
                'excerpt' => "Data pokok pendidikan (Dapodik) {$schoolName}.",
                'body' => '<p><strong>Jumlah Siswa:</strong> - </p>'
                    .'<p><strong>Jumlah Guru:</strong> - </p>'
                    .'<p><strong>Jumlah Tenaga Kependidikan:</strong> - </p>'
                    .'<p><strong>Jumlah Rombongan Belajar:</strong> - </p>'
                    .'<p><strong>Rasio Guru : Siswa:</strong> - </p>'
                    .'<p>Data ini sebaiknya diambil langsung dari Dapodik Kemdikbud '
                    .'(<a href="https://dapo.kemdikbud.go.id" target="_blank" rel="noopener">dapo.kemdikbud.go.id</a>) '
                    .'dengan mencari NPSN sekolah ini, supaya datanya akurat dan selalu bisa diperbarui.</p>'
                    .$disclaimer,
            ],
            [
                'type' => 'prestasi',
                'title' => "Prestasi {$schoolName}",
                'excerpt' => "Daftar prestasi akademik & non-akademik {$schoolName}.",
                'body' => '<p>Belum ada data prestasi. Admin dapat menambahkan daftar prestasi akademik '
                    .'(mis. juara olimpiade, lomba akademik) maupun non-akademik (mis. juara lomba seni, '
                    .'olahraga) di bagian ini, lengkap dengan tahun dan tingkat kejuaraannya.</p>'
                    .$disclaimer,
            ],
            [
                'type' => 'kontak',
                'title' => "Kontak Person {$schoolName}",
                'excerpt' => "Informasi kontak {$schoolName}.",
                'body' => '<p><strong>Alamat:</strong> - </p>'
                    .'<p><strong>Telepon/WhatsApp:</strong> - </p>'
                    .'<p><strong>Email:</strong> - </p>'
                    .'<p><strong>Kontak Person (Humas/TU):</strong> - </p>'
                    .'<p>Mohon isi dengan kontak resmi yang dikonfirmasi langsung ke pihak sekolah, '
                    .'bukan nomor pribadi tanpa izin.</p>'
                    .$disclaimer,
            ],
        ];
    }

    private function kecamatan(): array
    {
        return [
            'Ampelgading',
            'Bantur',
            'Bululawang',
            'Dampit',
            'Dau',
            'Donomulyo',
            'Gedangan',
            'Gondanglegi',
            'Jabung',
            'Kalipare',
            'Karangploso',
            'Kasembon',
            'Kepanjen',
            'Kromengan',
            'Lawang',
            'Ngajum',
            'Ngantang',
            'Pagak',
            'Pagelaran',
            'Pakis',
            'Pakisaji',
            'Poncokusumo',
            'Pujon',
            'Singosari',
            'Sumbermanjing Wetan',
            'Sumberpucung',
            'Tajinan',
            'Tirtoyudo',
            'Tumpang',
            'Turen',
            'Wagir',
            'Wajak',
            'Wonosari',
        ];
    }
}
