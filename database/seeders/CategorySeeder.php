<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Profile',
                'slug' => 'profile',
                'description' => 'Profil lengkap Kabupaten Malang: sejarah, geografi, pemerintahan, ekonomi, budaya, dan potensi daerah.',
                'icon' => '🏛️',
                'order' => 1,
            ],
            [
                'name' => 'Kecamatan',
                'slug' => 'kecamatan',
                'description' => 'Profil 33 kecamatan yang ada di wilayah Kabupaten Malang.',
                'icon' => '🗺️',
                'order' => 2,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
