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
     *   ├─ Air Terjun
     *   ├─ Gunung & Pendakian
     *   ├─ Wisata Religi & Budaya
     *   └─ Agrowisata & Wisata Buatan
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
            ['name' => 'Air Terjun', 'slug' => 'pariwisata-air-terjun', 'icon' => '💦', 'order' => 2, 'description' => 'Air terjun (coban) di kawasan pegunungan Kabupaten Malang.'],
            ['name' => 'Gunung & Pendakian', 'slug' => 'pariwisata-gunung-pendakian', 'icon' => '⛰️', 'order' => 3, 'description' => 'Jalur pendakian dan wisata pegunungan.'],
            ['name' => 'Wisata Religi & Budaya', 'slug' => 'pariwisata-religi-budaya', 'icon' => '🕌', 'order' => 4, 'description' => 'Candi, masjid, dan situs budaya bersejarah.'],
            ['name' => 'Agrowisata & Wisata Buatan', 'slug' => 'pariwisata-agrowisata', 'icon' => '🍏', 'order' => 5, 'description' => 'Kebun petik buah, peternakan, dan wahana wisata buatan.'],
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
    }
}
