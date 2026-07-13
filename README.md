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

## Admin Panel (AdminLTE 4)

Paket ini menambahkan panel admin di `/admin`, dibangun dengan **AdminLTE 4** (Bootstrap 5.3, tanpa jQuery) via CDN — tidak perlu install npm/composer package tambahan untuk tampilannya.

### Struktur kategori bertingkat (tree, seperti WordPress/Joomla)

Tabel `categories` sekarang punya kolom `parent_id`. Contoh struktur yang sudah di-seed:

```
Profile              (root, flat — tidak ada anak)
Kecamatan            (root, flat — tidak ada anak)
Pariwisata           (root)
  ├─ Pantai
  ├─ Air Terjun
  ├─ Gunung & Pendakian
  ├─ Wisata Religi & Budaya
  └─ Agrowisata & Wisata Buatan
```

Halaman **Manajemen Kategori** di admin menampilkan struktur ini sebagai tree dengan tombol tambah sub-kategori di tiap baris, persis pola WordPress/Joomla.

### 3 cara menambah artikel

Halaman **Artikel Baru** punya 3 tab di atas form:

1. **Manual** — isi form langsung.
2. **Scrape URL** — masukkan URL sumber, sistem mengambil judul/gambar/cuplikan teks via `ArticleScraperService` dan mengisi form secara otomatis. **Hasilnya wajib ditulis ulang dengan kalimat sendiri sebelum dipublikasikan** — ini konten mentah orang lain, bukan hasil akhir siap terbit (soal hak cipta).
3. **Generate AI** — masukkan topik, sistem memanggil Claude API lewat `AiArticleGenerator` untuk membuat draf judul/ringkasan/isi. Hasil AI **selalu masuk sebagai status Draft** dan wajib diverifikasi faktanya sebelum dipublikasikan (nama tempat, angka, sejarah, dll — model bisa saja salah).

### Langkah integrasi ke proyek Anda

1. Salin folder `app`, `database`, `resources`, `routes` ke proyek Laravel Anda (menambah, bukan mengganti yang sudah ada).
2. Tambahkan isi `routes/admin-additions.php` ke `routes/web.php`.
3. Daftarkan middleware `admin` di `bootstrap/app.php` (Laravel 11+/13):
   ```php
   ->withMiddleware(function (Illuminate\Foundation\Configuration\Middleware $middleware) {
       $middleware->alias([
           'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
       ]);
   })
   ```
4. Pastikan proyek Anda sudah punya sistem auth Laravel standar (tabel `users`, model `App\Models\User`). Jika belum ada login sama sekali, install Laravel Breeze (`composer require laravel/breeze` lalu `php artisan breeze:install blade`) agar tabel & model User siap — panel admin di sini memakai `Auth::attempt()` bawaan Laravel, bukan Breeze secara langsung, jadi Breeze opsional hanya untuk memastikan skema `users` ada.
5. Migrasi & seed:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
6. Login pertama kali di `/admin/login` dengan:
   - Email: `admin@malangkab.com`
   - Password: `ubah-password-ini`

   **Segera ganti password ini** setelah login (lewat `php artisan tinker` → `User::where('email','admin@malangkab.com')->first()->update(['password'=>Hash::make('password-baru-anda')])`), atau buat user admin sendiri lalu hapus/nonaktifkan akun default ini.

7. Untuk fitur **Generate AI**, tambahkan ke `.env`:
   ```
   ANTHROPIC_API_KEY=sk-ant-xxxxxxxx
   ANTHROPIC_MODEL=claude-sonnet-5
   ```
   dan ke `config/services.php`:
   ```php
   'anthropic' => [
       'key' => env('ANTHROPIC_API_KEY'),
       'model' => env('ANTHROPIC_MODEL', 'claude-sonnet-5'),
   ],
   ```
   Cek nama model API terbaru di [docs.claude.com](https://docs.claude.com) bila `claude-sonnet-5` sudah berganti.

### Catatan keamanan

- Middleware `admin` menolak akses (403) bagi user yang login tapi bukan admin (`is_admin = false`).
- Fitur scrape URL memakai `Http::get()` bawaan Laravel dengan timeout 15 detik — hanya untuk membaca halaman publik, bukan untuk situs yang butuh login.
- Jangan expose `ANTHROPIC_API_KEY` ke sisi klien (JS) — semua pemanggilan Claude API terjadi di server lewat `AiArticleGenerator`.

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
