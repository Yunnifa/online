<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
{
    // Nonaktifkan foreign key checks dulu
    \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    // Bersihkan data
    \App\Models\User::query()->delete();
    \App\Models\Wishlist::query()->delete(); // kalau perlu juga hapus data wishlist

    // Reset auto increment
    \DB::table('users')->truncate(); // opsional: kalau tetap mau reset ID
    \DB::table('wishlists')->truncate(); // juga opsional

    // Aktifkan kembali foreign key checks
    \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    // Buat data baru
    \App\Models\User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'role' => 'admin',
        'password' => \Hash::make('password'),
    ]);

    \App\Models\User::create([
        'name' => 'Test User',
        'email' => 'user@example.com',
        'role' => 'user',
        'password' => \Hash::make('password'),
    ]);
}

}
