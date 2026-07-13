<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * cover_image awalnya VARCHAR(255), tapi placeholder ikon sekolah memakai
     * data URI SVG (base64) yang panjangnya bisa >255 karakter, menyebabkan
     * error "value too long for type character varying(255)" di PostgreSQL.
     * Diperbesar jadi TEXT (tanpa batas praktis) supaya aman untuk data URI
     * maupun URL panjang lainnya.
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE articles ALTER COLUMN cover_image TYPE TEXT');
        } elseif ($driver === 'mysql') {
            DB::statement('ALTER TABLE articles MODIFY cover_image TEXT NULL');
        } else {
            // sqlite dan lainnya: kolom TEXT/VARCHAR sudah tanpa batas panjang praktis.
        }
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE articles ALTER COLUMN cover_image TYPE VARCHAR(255)');
        } elseif ($driver === 'mysql') {
            DB::statement('ALTER TABLE articles MODIFY cover_image VARCHAR(255) NULL');
        }
    }
};
