<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class PariwisataCategorySeeder extends Seeder
{
    /**
     * Struktur tree seperti kategori WordPress/Joomla:
     * Pariwisata (root)
     *   ├─ Pantai
     *   ├─ Wisata Alam           (gunung, pendakian, hutan, air terjun/coban, camping ground)
     *   ├─ Wisata Religi & Budaya (candi, museum, situs sejarah, budaya)
     *   ├─ Agrowisata & Wisata Buatan (kebun apel/buah, wisata buatan, pemandian, taman bermain)
     *   └─ Lainnya               (di luar 4 kategori di atas)
     */
    public function run(): void
    {
        $root = Category::updateOrCreate(
            ['slug' => 'pariwisata'],
            [
                'parent_id' => null,
                'name' => 'Pariwisata',
                'description' => 'Destinasi wisata unggulan di seluruh penjuru Kabupaten Malang.',
                'icon' => '🧭',
                'order' => 3,
            ]
        );

        $children = [
            ['name' => 'Pantai', 'slug' => 'pariwisata-pantai', 'icon' => '🏖️', 'order' => 1, 'description' => 'Deretan pantai pesisir selatan Kabupaten Malang.'],
            ['name' => 'Wisata Alam', 'slug' => 'pariwisata-wisata-alam', 'icon' => '⛰️', 'order' => 2, 'description' => 'Gunung, jalur pendakian, hutan, air terjun (coban), dan camping ground.'],
            ['name' => 'Wisata Religi & Budaya', 'slug' => 'pariwisata-religi-budaya', 'icon' => '🕌', 'order' => 3, 'description' => 'Candi, museum, tempat bersejarah, dan situs budaya.'],
            ['name' => 'Agrowisata & Wisata Buatan', 'slug' => 'pariwisata-agrowisata', 'icon' => '🍏', 'order' => 4, 'description' => 'Kebun petik apel/buah, pemandian, taman bermain anak, dan wisata buatan lainnya.'],
            ['name' => 'Lainnya', 'slug' => 'pariwisata-lainnya', 'icon' => '📍', 'order' => 5, 'description' => 'Destinasi wisata yang tidak masuk kategori di atas.'],
        ];

        foreach ($children as $child) {
            Category::updateOrCreate(
                ['slug' => $child['slug']],
                [
                    'parent_id' => $root->id,
                    'name' => $child['name'],
                    'description' => $child['description'],
                    'icon' => $child['icon'],
                    'order' => $child['order'],
                ]
            );
        }

        // Migrasi kategori lama (kalau proyek sudah pernah menjalankan seeder versi sebelumnya
        // yang masih punya "Air Terjun" & "Gunung & Pendakian" terpisah): pindahkan artikelnya
        // ke "Wisata Alam" yang baru, lalu hapus 2 kategori lama itu supaya tidak duplikat.
        $wisataAlam = Category::where('slug', 'pariwisata-wisata-alam')->first();
        foreach (['pariwisata-air-terjun', 'pariwisata-gunung-pendakian'] as $oldSlug) {
            $old = Category::where('slug', $oldSlug)->first();
            if ($old && $wisataAlam) {
                $old->articles()->update(['category_id' => $wisataAlam->id]);
                $old->delete();
            }
        }
    }
}
