<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * PENTING: ganti email & password ini (atau langsung lewat .env / tinker)
     * lalu SEGERA ganti password setelah login pertama kali.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@malangkab.com'],
            [
                'name' => 'Admin Malangkab',
                'password' => Hash::make('ubah-password-ini'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
