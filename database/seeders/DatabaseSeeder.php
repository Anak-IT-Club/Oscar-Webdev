<?php

namespace Database\Seeders;

use App\Models\Hadiah;
use App\Models\Sampah;
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
                'jurusan' => 'Teknik Jaringan Komputer dan Telekomunikasi',
                'no_hp' => '081298765432',
                'poin' => 50,
                'role' => 'siswa',
                'password' => Hash::make('password'),
            ]
        );

        $daftarSampah = [
            ['nama_sampah' => 'Sampah Dapur', 'jenis_sampah' => 'Organik', 'poin' => 8],
            ['nama_sampah' => 'Plastik Kemasan', 'jenis_sampah' => 'Non-Organik', 'poin' => 10],
            ['nama_sampah' => 'Baterai Bekas', 'jenis_sampah' => 'B3', 'poin' => 20],
            ['nama_sampah' => 'Pembalut & Pampers', 'jenis_sampah' => 'Residu', 'poin' => 5],
        ];

        foreach ($daftarSampah as $item) {
            Sampah::updateOrCreate(['nama_sampah' => $item['nama_sampah']], $item);
        }

        $daftarHadiah = [
            ['nama_hadiah' => 'Pulpen', 'poin' => 10],
            ['nama_hadiah' => 'Buku Tulis', 'poin' => 25],
            ['nama_hadiah' => 'Tumbler', 'poin' => 50],
            ['nama_hadiah' => 'Voucher Makan', 'poin' => 100],
        ];

        foreach ($daftarHadiah as $item) {
            Hadiah::updateOrCreate(['nama_hadiah' => $item['nama_hadiah']], $item);
        }
    }
}
