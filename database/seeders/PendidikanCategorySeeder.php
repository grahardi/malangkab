<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PendidikanCategorySeeder extends Seeder
{
    /**
     * Struktur tree 3 tingkat:
     * Pendidikan (root)
     *   ├─ TK, SD, SMA, SMK   (masih kosong, menyusul)
     *   └─ SMP                (berisi 1 sekolah per kecamatan: SMP Negeri 1)
     *        ├─ SMP Negeri 1 Ampelgading
     *        ├─ SMP Negeri 1 Bantur
     *        └─ dst. (33 kecamatan)
     */
    public function run(): void
    {
        $root = Category::updateOrCreate(
            ['slug' => 'pendidikan'],
            [
                'parent_id' => null,
                'name' => 'Pendidikan',
                'description' => 'Direktori sekolah di Kabupaten Malang, mulai dari TK hingga SMK.',
                'icon' => '🎓',
                'order' => 4,
            ]
        );

        $jenjang = [
            ['name' => 'TK', 'slug' => 'pendidikan-tk', 'icon' => '🎈', 'order' => 1, 'description' => 'Taman Kanak-Kanak di Kabupaten Malang.'],
            ['name' => 'SD', 'slug' => 'pendidikan-sd', 'icon' => '📗', 'order' => 2, 'description' => 'Sekolah Dasar di Kabupaten Malang.'],
            ['name' => 'SMP', 'slug' => 'pendidikan-smp', 'icon' => '🏫', 'order' => 3, 'description' => 'Sekolah Menengah Pertama di Kabupaten Malang.'],
            ['name' => 'SMA', 'slug' => 'pendidikan-sma', 'icon' => '🏛️', 'order' => 4, 'description' => 'Sekolah Menengah Atas di Kabupaten Malang.'],
            ['name' => 'SMK', 'slug' => 'pendidikan-smk', 'icon' => '🔧', 'order' => 5, 'description' => 'Sekolah Menengah Kejuruan di Kabupaten Malang.'],
        ];

        $jenjangModels = [];
        foreach ($jenjang as $j) {
            $jenjangModels[$j['slug']] = Category::updateOrCreate(
                ['slug' => $j['slug']],
                [
                    'parent_id' => $root->id,
                    'name' => $j['name'],
                    'description' => $j['description'],
                    'icon' => $j['icon'],
                    'order' => $j['order'],
                ]
            );
        }

        $smp = $jenjangModels['pendidikan-smp'];

        // Satu kategori per sekolah: SMP Negeri 1 di tiap 33 kecamatan.
        // Nama sekolah pakai pola penamaan standar Indonesia (SMP Negeri 1 + nama
        // kecamatan) -- pola ini sangat umum berlaku, tapi ADMIN TETAP PERLU
        // MENGONFIRMASI keberadaan & nama resmi tiap sekolah sebelum artikel
        // di-publish, karena penamaan di lapangan bisa saja berbeda.
        foreach ($this->kecamatan() as $i => $nama) {
            $schoolName = 'SMP Negeri 1 '.$nama;
            $slug = Str::slug($schoolName);

            Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'parent_id' => $smp->id,
                    'name' => $schoolName,
                    'description' => "Sekolah Menengah Pertama Negeri di Kecamatan {$nama}, Kabupaten Malang.",
                    'icon' => '🏫',
                    'order' => $i + 1,
                ]
            );
        }
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
