<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Menambahkan user dengan peran "admin"
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@koperasi.com',
            'password' => Hash::make('password'), //password
            'role' => 'admin',
            'nisn' => null,// NISN tidak diperlukan untuk admin
            'balance' => 0,
        ]);

        // // Menambahkan user dengan peran "kasir"
        // User::create([
        //     'name' => 'Petugas Kasir',
        //     'email' => 'kasir@koperasiku.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'kasir',
        //     'nisn' => null,
        //     'balance' => 0,
        // ]);

        // Menambahkan user dengan peran "siswa"
        User::create([
            'name' =>'Akun Siswa',
            'email' => 'siswa@koperasi.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'nisn' => '1234567890', //NISN unik
            'balance' => 0,
        ]);
    }
}
