<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class TokohCategorySeeder extends Seeder
{
    /**
     * Tokoh (root)
     *   ├─ Tokoh Politik
     *   ├─ Tokoh Pendidikan
     *   ├─ Tokoh Masyarakat
     *   ├─ Budayawan
     *   ├─ Artis Malang
     *   ├─ Atlet
     *   └─ Tokoh Lainnya
     */
    public function run(): void
    {
        $root = Category::updateOrCreate(
            ['slug' => 'tokoh'],
            [
                'parent_id' => null,
                'name' => 'Tokoh',
                'description' => 'Profil tokoh-tokoh yang lahir, besar, atau berkarya di Malang dan memberi sumbangsih bagi Indonesia.',
                'icon' => '👤',
                'order' => 5,
            ]
        );

        $children = [
            ['name' => 'Tokoh Politik', 'slug' => 'tokoh-politik', 'icon' => '🏛️', 'order' => 1, 'description' => 'Tokoh di bidang pemerintahan, politik, dan kenegaraan.'],
            ['name' => 'Tokoh Pendidikan', 'slug' => 'tokoh-pendidikan', 'icon' => '🎓', 'order' => 2, 'description' => 'Tokoh yang berkontribusi di bidang pendidikan.'],
            ['name' => 'Tokoh Masyarakat', 'slug' => 'tokoh-masyarakat', 'icon' => '🤝', 'order' => 3, 'description' => 'Tokoh masyarakat, pengusaha, dan penggerak sosial.'],
            ['name' => 'Budayawan', 'slug' => 'tokoh-budayawan', 'icon' => '🎭', 'order' => 4, 'description' => 'Budayawan, seniman, dan maestro seni tradisi Malang.'],
            ['name' => 'Artis Malang', 'slug' => 'tokoh-artis', 'icon' => '🎬', 'order' => 5, 'description' => 'Artis dan pekerja seni hiburan asal Malang.'],
            ['name' => 'Atlet', 'slug' => 'tokoh-atlet', 'icon' => '🏆', 'order' => 6, 'description' => 'Atlet dan olahragawan asal Malang.'],
            ['name' => 'Tokoh Lainnya', 'slug' => 'tokoh-lainnya', 'icon' => '📌', 'order' => 7, 'description' => 'Tokoh yang tidak masuk kategori di atas.'],
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
