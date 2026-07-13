<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Gabungkan pemanggilan ini ke dalam DatabaseSeeder proyek Anda yang sudah ada.
     * Urutan penting: Category dulu, baru Article.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            CategorySeeder::class,
            PariwisataCategorySeeder::class,
            ProfileArticleSeeder::class,
            KecamatanArticleSeeder::class,
            PariwisataArticleSeeder::class,
        ]);
    }
}
