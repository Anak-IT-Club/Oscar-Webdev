<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@smart.site'],
            [
                'nisn' => 'ADM001',
                'nama' => 'Administrator',
                'kelas' => '-',
                'jurusan' => '-',
                'no_hp' => '081234567890',
                'poin' => 0,
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'siswa@smart.site'],
            [
                'nisn' => 'SIS001',
                'nama' => 'Siswa Contoh',
                'kelas' => 'XII RPL',
                'jurusan' => 'Rekayasa Perangkat Lunak',
                'no_hp' => '081298765432',
                'poin' => 50,
                'role' => 'siswa',
                'password' => Hash::make('password'),
            ]
        );
    }
}
