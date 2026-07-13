<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PariwisataArticleSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->data() as $item) {
            $category = Category::where('slug', $item['category_slug'])->first();

            if (! $category) {
                continue; // jalankan PariwisataCategorySeeder dulu
            }

            $slug = Str::slug($item['title']);

            Article::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $category->id,
                    'title' => $item['title'],
                    'excerpt' => $item['excerpt'],
                    'body' => $item['body'],
                    'cover_image' => $item['cover_image'],
                    'gallery' => $item['gallery'] ?? [],
                    'meta' => ['image_source' => 'wikimedia_commons'],
                    'status' => 'published',
                    'published_at' => now(),
                ]
            );
        }
    }

    private function data(): array
    {
        return [
            [
                'category_slug' => 'pariwisata-pantai',
                'title' => 'Pantai Balekambang',
                'excerpt' => 'Pantai ikonis di Kecamatan Bantur dengan Pura Amerta Jati di atas Pulau Ismoyo, mirip suasana Tanah Lot.',
                'cover_image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Pura_Balekambang.png?width=1200',
                'gallery' => ['https://commons.wikimedia.org/wiki/Special:FilePath/Pura_Balekambang.png?width=900'],
                'body' => '<p>Pantai Balekambang berada di Kecamatan Bantur, sekitar 65 km selatan pusat Kota Malang. Daya tarik utamanya adalah Pura Amerta Jati yang berdiri di atas Pulau Ismoyo, terhubung ke pantai lewat jembatan sepanjang sekitar 70 meter — pemandangan yang membuatnya sering disandingkan dengan Tanah Lot di Bali.</p><p>Selain pura, terdapat dua pulau karang lain yaitu Pulau Anoman dan Pulau Wisanggeni, serta hamparan pasir putih yang cukup luas untuk aktivitas piknik dan berkemah.</p><p class="text-sm text-gray-500">Foto Pura Amerta Jati — Wikimedia Commons, lisensi CC BY-SA 3.0.</p>',
            ],
            [
                'category_slug' => 'pariwisata-pantai',
                'title' => 'Pulau Sempu & Pantai Sendang Biru',
                'excerpt' => 'Cagar alam dengan laguna biru Segara Anakan, diakses lewat pelabuhan nelayan Sendang Biru di Sumbermanjing Wetan.',
                'cover_image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Pulau_Sempu_(Sempu_Island).jpg?width=1200',
                'gallery' => ['https://commons.wikimedia.org/wiki/Special:FilePath/Pulau_Sempu_(Sempu_Island).jpg?width=900'],
                'body' => '<p>Pulau Sempu adalah kawasan cagar alam seluas kurang lebih 877 hektare di Kecamatan Sumbermanjing Wetan, tidak jauh dari pesisir pantai selatan. Untuk mencapainya, pengunjung harus menyeberang lewat Pantai Sendang Biru yang juga berfungsi sebagai pelabuhan pendaratan ikan.</p><p>Daya tarik utama pulau ini adalah Segara Anakan, sebuah laguna air biru kehijauan yang terbentuk dari air laut yang merembes melalui celah karang. Karena berstatus cagar alam, kunjungan ke dalam pulau memerlukan izin dan bertujuan konservasi, bukan wisata massal.</p><p class="text-sm text-gray-500">Foto Pulau Sempu — Wikimedia Commons, oleh Fortraihan, lisensi CC BY-SA 4.0.</p>',
            ],
            [
                'category_slug' => 'pariwisata-pantai',
                'title' => 'Pantai Ngliyep',
                'excerpt' => 'Salah satu pantai selatan tertua di Kabupaten Malang, populer sejak era 1980-an, terletak di Kecamatan Donomulyo.',
                'cover_image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Pantai_Ngliyep_(Ngliyep_Beach_Donomulyo).jpg?width=1200',
                'gallery' => ['https://commons.wikimedia.org/wiki/Special:FilePath/Pantai_Ngliyep_(Ngliyep_Beach_Donomulyo).jpg?width=900'],
                'body' => '<p>Pantai Ngliyep terletak di Desa Kedungsalam, Kecamatan Donomulyo, sekitar 62 km selatan Kota Malang. Sebelum Balekambang dan Sendang Biru populer, Ngliyep sudah lebih dulu menjadi tujuan wisata favorit sejak dekade 1980-an.</p><p>Kawasan ini dikelilingi tebing curam dan hutan lindung, dengan Teluk Putri yang berpasir putih halus di sisi kiri pantai utama. Setiap tanggal 14 bulan Maulud, digelar upacara adat labuhan sebagai tradisi tahunan masyarakat setempat.</p><p class="text-sm text-gray-500">Foto Pantai Ngliyep — Wikimedia Commons, oleh Angga Prastyo10, lisensi CC BY-SA 4.0.</p>',
            ],
            [
                'category_slug' => 'pariwisata-wisata-alam',
                'title' => 'Air Terjun Coban Rondo',
                'excerpt' => 'Air terjun setinggi 84 meter di lereng Gunung Panderman, Kecamatan Pujon, lengkap dengan area berkemah.',
                'cover_image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Coban_Rondo_Waterfall.jpg?width=1200',
                'gallery' => ['https://commons.wikimedia.org/wiki/Special:FilePath/Coban_Rondo_Waterfall.jpg?width=900'],
                'body' => '<p>Coban Rondo berada di Desa Pandesari, Kecamatan Pujon, pada ketinggian sekitar 1.135 mdpl dengan udara pegunungan yang sejuk. Air terjun ini memiliki tinggi sekitar 84 meter dan merupakan hilir dari rangkaian air terjun bertingkat Coban Manten dan Coban Dudo.</p><p>Fasilitas di kawasan ini mencakup area berkemah, jalur jogging, kolam pemancingan, serta penginapan — menjadikannya salah satu destinasi wisata alam paling lengkap di wilayah barat Kabupaten Malang.</p><p class="text-sm text-gray-500">Foto Air Terjun Coban Rondo — Wikimedia Commons, lisensi CC BY-SA 2.0.</p>',
            ],
            [
                'category_slug' => 'pariwisata-wisata-alam',
                'title' => 'Jalur Bromo-Semeru via Poncokusumo',
                'excerpt' => 'Salah satu jalur menuju kawasan Taman Nasional Bromo Tengger Semeru, melalui Kecamatan Poncokusumo.',
                'cover_image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/TNBTS_Jemplang_Malang_Jatim.jpg?width=1200',
                'gallery' => ['https://commons.wikimedia.org/wiki/Special:FilePath/TNBTS_Jemplang_Malang_Jatim.jpg?width=900'],
                'body' => '<p>Kecamatan Poncokusumo menjadi salah satu pintu masuk menuju kawasan Taman Nasional Bromo Tengger Semeru (TNBTS) dari sisi Kabupaten Malang, selain jalur via Kecamatan Tumpang.</p><p>Selain akses menuju Gunung Bromo dan Gunung Semeru, wilayah ini juga dikenal dengan agrowisata petik apel dataran tinggi yang bisa dinikmati sebelum atau sesudah pendakian.</p><p class="text-sm text-gray-500">Foto kawasan TNBTS, Jemplang — Wikimedia Commons, oleh Indiekreatif, lisensi CC BY-SA 4.0.</p>',
            ],
            [
                'category_slug' => 'pariwisata-religi-budaya',
                'title' => 'Candi Singosari',
                'excerpt' => 'Candi peninggalan Kerajaan Singhasari abad ke-13 di Kecamatan Singosari, salah satu situs sejarah utama Malang Raya.',
                'cover_image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Candi_Singosari_B.JPG?width=1200',
                'gallery' => ['https://commons.wikimedia.org/wiki/Special:FilePath/Candi_Singosari_B.JPG?width=900'],
                'body' => '<p>Candi Singosari terletak sekitar 10 km utara Kota Malang, di Kecamatan Singosari. Candi ini diperkirakan dibangun untuk menghormati Raja Kertanagara, raja terakhir Kerajaan Singhasari yang wafat pada 1292 Masehi.</p><p>Di area sekitar candi terdapat dua arca raksasa Dwarapala yang dipercaya sebagai penjaga gerbang istana. Situs ini menjadi salah satu bukti kejayaan Kerajaan Singhasari yang berpusat di wilayah Malang.</p><p class="text-sm text-gray-500">Foto Candi Singosari — Wikimedia Commons, lisensi CC BY-SA 3.0.</p>',
            ],
            [
                'category_slug' => 'pariwisata-religi-budaya',
                'title' => 'Candi Jago',
                'excerpt' => 'Candi pendarmaan Raja Wisnuwardhana di Kecamatan Tumpang, dikenal dengan relief Kunjarakarna dan Pancatantra.',
                'cover_image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Candi_Jago_C.JPG?width=1200',
                'gallery' => ['https://commons.wikimedia.org/wiki/Special:FilePath/Candi_Jago_C.JPG?width=900'],
                'body' => '<p>Candi Jago, atau dikenal juga dengan nama asli "Jajaghu", berada di Kecamatan Tumpang sekitar 22 km timur Kota Malang. Candi ini dibangun untuk menghormati Raja Wisnuwardhana dari Kerajaan Singhasari yang wafat pada 1268.</p><p>Keunikan Candi Jago terletak pada relief-reliefnya yang menggambarkan cerita Kunjarakarna dan Pancatantra, serta bentuk bangunannya yang menyerupai punden berundak — ciri arsitektur masa peralihan Hindu-Buddha Jawa Timur.</p><p class="text-sm text-gray-500">Foto Candi Jago — Wikimedia Commons, lisensi CC BY-SA 3.0.</p>',
            ],
        ];
    }
}
