# Malangkab.com — Addon Profil & Kecamatan

Paket ini berisi file tambahan untuk proyek **Laravel 13 (PHP 8.5 + PostgreSQL)** yang sudah Anda miliki. Isinya: migration, model, seeder (10 artikel kategori **Profile** + 33 artikel kategori **Kecamatan**), controller, route, dan view bertema majalah/profil daerah untuk malangkab.com.

> Catatan: paket ini file siap-pakai, bukan hasil `laravel new`. Anda tinggal menyalinnya ke proyek Laravel yang sudah berjalan.

## Struktur

```
app/Http/Controllers/ArticleController.php
app/Models/Category.php
app/Models/Article.php
database/migrations/2026_07_13_000001_create_categories_table.php
database/migrations/2026_07_13_000002_create_articles_table.php
database/seeders/CategorySeeder.php
database/seeders/ProfileArticleSeeder.php
database/seeders/KecamatanArticleSeeder.php
database/seeders/DatabaseSeeder.php   <- contoh, gabungkan ke DatabaseSeeder Anda
routes/web-additions.php              <- salin isinya ke routes/web.php
resources/views/layouts/app.blade.php
resources/views/partials/nav.blade.php
resources/views/partials/footer.blade.php
resources/views/home.blade.php
resources/views/articles/index.blade.php
resources/views/articles/show.blade.php
```

## Langkah instalasi ke proyek Anda

1. **Salin folder `app`, `database`, `resources` di paket ini ke root proyek Laravel Anda** (menimpa/menambah file, bukan mengganti folder yang sudah ada).
2. **Routing** — buka `routes/web.php`, tambahkan isi dari `routes/web-additions.php`:
   ```php
   use App\Http\Controllers\ArticleController;

   Route::get('/', [ArticleController::class, 'home'])->name('home');
   Route::get('/{category}', [ArticleController::class, 'category'])->name('category.show');
   Route::get('/{category}/{article}', [ArticleController::class, 'show'])->name('article.show');
   ```
   Jika Anda sudah punya route `/` sebelumnya, sesuaikan agar tidak bentrok.
3. **DatabaseSeeder** — buka `database/seeders/DatabaseSeeder.php` milik Anda, tambahkan pemanggilan:
   ```php
   $this->call([
       CategorySeeder::class,
       ProfileArticleSeeder::class,
       KecamatanArticleSeeder::class,
   ]);
   ```
4. **Migrasi & seed** (pastikan koneksi PostgreSQL di `.env` sudah benar):
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
5. Jalankan `php artisan serve` lalu buka `http://127.0.0.1:8000` — beranda, halaman `/profile`, `/kecamatan`, dan detail artikel per-kecamatan sudah aktif.

## Tentang gambar

Seeder memakai gambar placeholder dari **Lorem Picsum** (`picsum.photos`, layanan foto bebas pakai untuk pengembangan) berdasarkan seed nama artikel, supaya tiap artikel punya cover + galeri yang konsisten sejak awal.

**Kenapa tidak langsung ambil dari hasil pencarian Google Images?** Foto yang muncul di pencarian pada umumnya berhak cipta milik fotografer/situs asal — menaruhnya di situs publik tanpa izin berisiko pelanggaran hak cipta. Beberapa alternatif yang aman:

1. **Wikimedia Commons** — banyak foto landmark (candi, pantai, masjid, dsb.) berlisensi Creative Commons (bebas pakai dengan syarat mencantumkan atribusi). Sejauh ini **7 dari 33 kecamatan** sudah pakai foto asli terverifikasi lisensinya, lewat `KecamatanArticleSeeder::realPhotos()`:
   - Singosari → Candi Singosari (CC BY-SA 3.0)
   - Bantur → Pura Amerta Jati, Pantai Balekambang (CC BY-SA 3.0)
   - Sumbermanjing Wetan → Pulau Sempu (CC BY-SA 4.0)
   - Poncokusumo → kawasan Taman Nasional Bromo Tengger Semeru, Jemplang (CC BY-SA 4.0)
   - Donomulyo → Pantai Ngliyep (CC BY-SA 4.0)
   - Tumpang → Candi Jago (CC BY-SA 3.0)
   - Pujon → Air Terjun Coban Rondo (CC BY-SA 2.0)

   Untuk kecamatan lain: cari file di commons.wikimedia.org, lalu pakai URL stabil:
   ```
   https://commons.wikimedia.org/wiki/Special:FilePath/Nama_File.jpg
   ```
   Tambahkan entrinya ke method `realPhotos()` beserta teks kredit — sisanya otomatis terpasang saat seeding.
2. **Dokumentasi resmi Pemkab/Diskominfo Kabupaten Malang** — paling ideal karena biasanya sudah dimiliki hak pakainya oleh instansi terkait.
3. **Foto sendiri** per kecamatan, diunggah lewat storage Laravel (`php artisan storage:link`) dan diisi ke kolom `cover_image`/`gallery` sebagai path lokal.

## Kartu kecamatan acak di beranda

Di beranda, bagian "Sekilas Kecamatan" menampilkan **6 kartu thumbnail kecamatan secara acak** (2 kolom × 3 baris), berbeda setiap kali halaman dimuat ulang — diambil lewat `Article::inRandomOrder()->limit(6)` di `ArticleController@home`. Daftar lengkap 33 kecamatan tetap bisa diakses di halaman `/kecamatan`.

## Tentang konten

Isi 10 artikel "Profile" dan 33 artikel "Kecamatan" adalah **draf awal** (ringkasan umum, gaya ensiklopedis) yang aman dipakai sebagai starter content. Untuk data resmi (jumlah desa, luas wilayah, jumlah penduduk per kecamatan, potensi unggulan terbaru), sebaiknya dilengkapi dari data BPS Kabupaten Malang / Diskominfo agar akurat dan bisa diklaim sebagai data resmi pemerintah daerah.

## Menghubungkan ke GitHub

Saya tidak memiliki akses ke akun/repo GitHub Anda, jadi bagian ini perlu dijalankan dari sisi Anda (di terminal proyek Laravel Anda, setelah file di atas disalin masuk):

```bash
# jika proyek belum pernah di-init git
git init
git add .
git commit -m "Add profile & kecamatan magazine module for malangkab.com"

# hubungkan ke repo GitHub (buat dulu repo kosong di github.com jika belum ada)
git remote add origin https://github.com/USERNAME/NAMA-REPO.git
git branch -M main
git push -u origin main
```

Jika repo sudah ada dan sudah terhubung sebelumnya:
```bash
git add .
git commit -m "Add profile & kecamatan magazine module"
git push
```

Kalau Anda beri tahu saya nama repo GitHub-nya (atau hubungkan konektor GitHub di percakapan ini), saya bisa bantu susun isi commit/PR-nya juga.
