<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Seeder untuk admin
        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'nama' => 'Admin User',
            'jenis_kelamin' => 'laki-laki',
            'role' => 'admin',
            'alamat' => 'Alamat Admin',
            'nohp' => '081234567890',
            'email' => 'admin@example.com',
            'foto' => null,
        ]);

        // Seeder untuk owner
        User::create([
            'username' => 'owner',
            'password' => Hash::make('owner123'),
            'nama' => 'Owner User',
            'jenis_kelamin' => 'perempuan',
            'role' => 'owner',
            'alamat' => 'Alamat Owner',
            'nohp' => '081234567891',
            'email' => 'owner@example.com',
            'foto' => null,
        ]);

        // Seeder untuk karyawan
        User::create([
            'username' => 'karyawan',
            'password' => Hash::make('karyawan123'),
            'nama' => 'Karyawan User',
            'jenis_kelamin' => 'laki-laki',
            'role' => 'karyawan',
            'alamat' => 'Alamat Karyawan',
            'nohp' => '081234567892',
            'email' => 'karyawan@example.com',
            'foto' => null,
        ]);
    }
}
