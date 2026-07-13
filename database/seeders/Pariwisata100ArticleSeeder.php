<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Pariwisata100ArticleSeeder extends Seeder
{
    /**
     * 100 draf artikel wisata (20 per sub-kategori) untuk mengisi konten awal
     * Pariwisata: Pantai, Wisata Alam, Wisata Religi & Budaya, Agrowisata &
     * Wisata Buatan, dan Lainnya.
     *
     * PENTING: semua artikel di sini disimpan dengan status 'draft', BUKAN
     * langsung 'published'. Sebagian nama tempat sudah cukup dikenal luas,
     * tapi sebagian lain masih berupa perkiraan/starter yang perlu diverifikasi
     * admin (lewat panel admin) sebelum tayang ke publik -- terutama soal
     * kecamatan persis, jam operasional, harga tiket, dan detail teknis lain.
     */
    public function run(): void
    {
        foreach ($this->data() as $categorySlug => $items) {
            $category = Category::where('slug', $categorySlug)->first();

            if (! $category) {
                continue; // jalankan PariwisataCategorySeeder dulu
            }

            foreach ($items as $item) {
                $slug = Str::slug($categorySlug.'-'.$item['nama']);

                $body = "<p>{$item['nama']} merupakan salah satu destinasi wisata di kategori {$category->name}, "
                    ."berada di kawasan {$item['wilayah']}, Kabupaten Malang.</p>"
                    .'<p><em>Catatan: ini draf awal starter content. Detail seperti kecamatan persis, jam operasional, '
                    .'harga tiket, dan cara akses perlu dilengkapi/diverifikasi admin melalui panel admin sebelum artikel '
                    .'dipublikasikan.</em></p>';

                Article::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'category_id' => $category->id,
                        'title' => $item['nama'],
                        'excerpt' => "Destinasi {$category->name} di kawasan {$item['wilayah']}, Kabupaten Malang.",
                        'body' => $body,
                        'cover_image' => "https://picsum.photos/seed/{$slug}/1200/700",
                        'gallery' => [
                            "https://picsum.photos/seed/{$slug}-1/900/600",
                            "https://picsum.photos/seed/{$slug}-2/900/600",
                        ],
                        'meta' => ['wilayah' => $item['wilayah'], 'image_source' => 'placeholder'],
                        'status' => 'draft',
                        'published_at' => null,
                    ]
                );
            }
        }
    }

    private function data(): array
    {
        return [
            'pariwisata-pantai' => [
                ['nama' => 'Pantai Balekambang', 'wilayah' => 'Bantur'],
                ['nama' => 'Pantai Ngliyep', 'wilayah' => 'Donomulyo'],
                ['nama' => 'Pantai Sendang Biru', 'wilayah' => 'Sumbermanjing Wetan'],
                ['nama' => 'Pantai Tiga Warna', 'wilayah' => 'Sumbermanjing Wetan'],
                ['nama' => 'Pantai Goa Cina', 'wilayah' => 'Sumbermanjing Wetan'],
                ['nama' => 'Pantai Clungup', 'wilayah' => 'Sumbermanjing Wetan'],
                ['nama' => 'Pantai Gatra', 'wilayah' => 'Sumbermanjing Wetan'],
                ['nama' => 'Pantai Modangan', 'wilayah' => 'Donomulyo'],
                ['nama' => 'Pantai Ngopet', 'wilayah' => 'pesisir selatan Kabupaten Malang'],
                ['nama' => 'Pantai Kondang Merak', 'wilayah' => 'Bantur'],
                ['nama' => 'Pantai Bajul Mati', 'wilayah' => 'Gedangan'],
                ['nama' => 'Pantai Lenggoksono', 'wilayah' => 'Ampelgading'],
                ['nama' => 'Pantai Wediawu (Watu Leter)', 'wilayah' => 'Ampelgading'],
                ['nama' => 'Pantai Jonggring Saloka', 'wilayah' => 'Tirtoyudo'],
                ['nama' => 'Pantai Licin', 'wilayah' => 'Ampelgading'],
                ['nama' => 'Pantai Sipelot', 'wilayah' => 'Tirtoyudo'],
                ['nama' => 'Pantai Ngantep', 'wilayah' => 'Sumbermanjing Wetan'],
                ['nama' => 'Pantai Kondang Iwak', 'wilayah' => 'Bantur'],
                ['nama' => 'Pantai Batu Bengkung', 'wilayah' => 'Bantur'],
                ['nama' => 'Pantai Ngudel', 'wilayah' => 'pesisir selatan Kabupaten Malang'],
            ],
            'pariwisata-wisata-alam' => [
                ['nama' => 'Coban Pelangi', 'wilayah' => 'Poncokusumo'],
                ['nama' => 'Coban Trisula', 'wilayah' => 'Tumpang'],
                ['nama' => 'Coban Jahe', 'wilayah' => 'Karangploso'],
                ['nama' => 'Coban Sumber Pitu', 'wilayah' => 'Tumpang'],
                ['nama' => 'Coban Parang Tejo', 'wilayah' => 'Poncokusumo'],
                ['nama' => 'Coban Kethak (Coban Singo Edan)', 'wilayah' => 'Kasembon'],
                ['nama' => 'Bumi Perkemahan Ledok Ombo', 'wilayah' => 'Poncokusumo'],
                ['nama' => 'Jalur Pendakian Gunung Semeru via Ranu Pani', 'wilayah' => 'Poncokusumo'],
                ['nama' => 'Bukit Budug Asu', 'wilayah' => 'Karangploso'],
                ['nama' => 'Hutan Pinus Sumbermanjing', 'wilayah' => 'Sumbermanjing Wetan'],
                ['nama' => 'Wisata Jemplang Menuju Bromo', 'wilayah' => 'Poncokusumo'],
                ['nama' => 'Camping Ground Coban Rondo', 'wilayah' => 'Pujon'],
                ['nama' => 'Bukit Panorama Poncokusumo', 'wilayah' => 'Poncokusumo'],
                ['nama' => 'Ranu Regulo', 'wilayah' => 'Poncokusumo'],
                ['nama' => 'Hutan Pinus Coban Trisula', 'wilayah' => 'Tumpang'],
                ['nama' => 'Wana Wisata Kondang Buntung', 'wilayah' => 'kawasan pegunungan Kabupaten Malang'],
                ['nama' => 'Bukit Delistiwa', 'wilayah' => 'Wagir'],
                ['nama' => 'Camping Ground Ngliyep', 'wilayah' => 'Donomulyo'],
                ['nama' => 'Air Terjun Watu Ondo', 'wilayah' => 'Poncokusumo'],
                ['nama' => 'Kawasan Hutan Tahura R. Soerjo Sisi Malang', 'wilayah' => 'Pujon'],
            ],
            'pariwisata-religi-budaya' => [
                ['nama' => 'Candi Kidal', 'wilayah' => 'Tajinan'],
                ['nama' => 'Candi Badut', 'wilayah' => 'Dau'],
                ['nama' => 'Candi Sumberawan', 'wilayah' => 'Singosari'],
                ['nama' => 'Masjid Tiban (Ponpes Salafiyah Bihaaru Bahri)', 'wilayah' => 'Turen'],
                ['nama' => 'Pesarean Gunung Kawi', 'wilayah' => 'Wonosari'],
                ['nama' => 'Petirtaan Watugede', 'wilayah' => 'Singosari'],
                ['nama' => 'Arca Dwarapala Singosari', 'wilayah' => 'Singosari'],
                ['nama' => 'Stasiun Kereta Api Lawang', 'wilayah' => 'Lawang'],
                ['nama' => 'Bangunan Kolonial RSJ Lawang', 'wilayah' => 'Lawang'],
                ['nama' => 'Situs Watu Gong', 'wilayah' => 'kawasan Malang Raya'],
                ['nama' => 'Petilasan Eyang Djoego', 'wilayah' => 'Wonosari'],
                ['nama' => 'Makam Bersejarah Desa Setempat', 'wilayah' => 'kecamatan yang belum dipastikan, perlu dilengkapi admin'],
                ['nama' => 'Klenteng/Vihara Kawasan Kepanjen', 'wilayah' => 'Kepanjen'],
                ['nama' => 'Klenteng/Vihara Kawasan Turen', 'wilayah' => 'Turen'],
                ['nama' => 'Kampung Budaya dan Adat Setempat', 'wilayah' => 'kecamatan yang belum dipastikan, perlu dilengkapi admin'],
                ['nama' => 'Situs Purbakala Kawasan Singosari', 'wilayah' => 'Singosari'],
                ['nama' => 'Tradisi Bantengan sebagai Wisata Budaya', 'wilayah' => 'lintas kecamatan di Kabupaten Malang'],
                ['nama' => 'Wisata Religi Ziarah Wali Setempat', 'wilayah' => 'kecamatan yang belum dipastikan, perlu dilengkapi admin'],
                ['nama' => 'Museum/Rumah Budaya Kecamatan', 'wilayah' => 'kecamatan yang belum dipastikan, perlu dilengkapi admin'],
                ['nama' => 'Punden Berundak/Situs Megalitikum Setempat', 'wilayah' => 'kecamatan yang belum dipastikan, perlu dilengkapi admin'],
            ],
            'pariwisata-agrowisata' => [
                ['nama' => 'Wisata Petik Apel Poncokusumo', 'wilayah' => 'Poncokusumo'],
                ['nama' => 'Wisata Edukasi Susu Sae Pujon', 'wilayah' => 'Pujon'],
                ['nama' => 'Pemandian Wendit', 'wilayah' => 'Pakis'],
                ['nama' => 'Pemandian Dewi Sri Lebaksari', 'wilayah' => 'Pujon'],
                ['nama' => 'Pemandian Metro Kepanjen', 'wilayah' => 'Kepanjen'],
                ['nama' => 'Pemandian Kendedes', 'wilayah' => 'Singosari'],
                ['nama' => 'Pemandian Sengkaling', 'wilayah' => 'Dau'],
                ['nama' => 'Agrowisata Kebun Teh Wonosari', 'wilayah' => 'Wonosari'],
                ['nama' => 'Wisata Petik Buah Wonoagung', 'wilayah' => 'Kasembon'],
                ['nama' => 'Wisata Petik Jeruk Pandesari', 'wilayah' => 'Pujon'],
                ['nama' => 'Wisata Petik Apel Madiredo', 'wilayah' => 'Pujon'],
                ['nama' => 'Wisata Petik Jambu Ngantang', 'wilayah' => 'Ngantang'],
                ['nama' => 'Taman Kemesraan', 'wilayah' => 'Pujon'],
                ['nama' => 'Kasembon Park', 'wilayah' => 'Kasembon'],
                ['nama' => 'Wisata Edukasi Batik Tulis Wonoagung', 'wilayah' => 'Kasembon'],
                ['nama' => 'Wisata Edukasi Goa Lemah Deng', 'wilayah' => 'Kasembon'],
                ['nama' => 'Agrowisata Petik Buah Naga', 'wilayah' => 'kecamatan yang belum dipastikan, perlu dilengkapi admin'],
                ['nama' => 'Kolam Renang Wisata Kecamatan', 'wilayah' => 'kecamatan yang belum dipastikan, perlu dilengkapi admin'],
                ['nama' => 'Peternakan Edukasi Sapi Perah Ngantang', 'wilayah' => 'Ngantang'],
                ['nama' => 'Wahana Bermain Anak Kecamatan', 'wilayah' => 'kecamatan yang belum dipastikan, perlu dilengkapi admin'],
            ],
            'pariwisata-lainnya' => [
                ['nama' => 'Waduk Karangkates (Bendungan Sutami)', 'wilayah' => 'Sumberpucung'],
                ['nama' => 'Waduk Selorejo', 'wilayah' => 'Ngantang'],
                ['nama' => 'Desa Wisata Wonoagung', 'wilayah' => 'Kasembon'],
                ['nama' => 'Sentra Tenun/Sarung', 'wilayah' => 'Bululawang'],
                ['nama' => 'Rafting Kasembon (Kali Konto)', 'wilayah' => 'Kasembon'],
                ['nama' => 'Rafting Kali Konto (D\'Konto Rafting)', 'wilayah' => 'Pujon'],
                ['nama' => 'Pasar Wisata Kuliner', 'wilayah' => 'Kepanjen'],
                ['nama' => 'Alun-Alun Kepanjen', 'wilayah' => 'Kepanjen'],
                ['nama' => 'Kampung Tematik', 'wilayah' => 'kecamatan yang belum dipastikan, perlu dilengkapi admin'],
                ['nama' => 'Sentra Oleh-Oleh Keripik Apel', 'wilayah' => 'Pujon'],
                ['nama' => 'Spot Foto Bukit', 'wilayah' => 'kecamatan yang belum dipastikan, perlu dilengkapi admin'],
                ['nama' => 'Pasar Hewan Tradisional', 'wilayah' => 'kecamatan yang belum dipastikan, perlu dilengkapi admin'],
                ['nama' => 'Sentra Kerajinan Bambu', 'wilayah' => 'kecamatan yang belum dipastikan, perlu dilengkapi admin'],
                ['nama' => 'Wisata Edukasi Kopi Dampit', 'wilayah' => 'Dampit'],
                ['nama' => 'Wisata Edukasi Kopi Tirtoyudo', 'wilayah' => 'Tirtoyudo'],
                ['nama' => 'Embung Desa', 'wilayah' => 'kecamatan yang belum dipastikan, perlu dilengkapi admin'],
                ['nama' => 'Sentra Anyaman', 'wilayah' => 'kecamatan yang belum dipastikan, perlu dilengkapi admin'],
                ['nama' => 'Wisata Malam Alun-Alun Kepanjen', 'wilayah' => 'Kepanjen'],
                ['nama' => 'Wisata Belanja Oleh-Oleh Khas Malang', 'wilayah' => 'Kepanjen'],
                ['nama' => 'Ikon Foto/Jembatan Kecamatan', 'wilayah' => 'kecamatan yang belum dipastikan, perlu dilengkapi admin'],
            ],
        ];
    }
}
