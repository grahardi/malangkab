<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class BeritaCategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::updateOrCreate(
            ['slug' => 'berita'],
            [
                'parent_id' => null,
                'name' => 'Berita',
                'description' => 'Ringkasan berita seputar Kabupaten Malang dan Malang Raya.',
                'icon' => '📰',
                'order' => 6,
            ]
        );
    }
}
