<?php

namespace Database\Seeders;

use App\Models\Nasabah;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NasabahSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample nasabah accounts
        $nasabahData = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'alamat' => 'Jl. Contoh No. 123',
                'no_telepon' => '081234567890'
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'alamat' => 'Jl. Sample No. 456',
                'no_telepon' => '081234567891'
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'alamat' => 'Jl. Test No. 789',
                'no_telepon' => '081234567892'
            ]
        ];

        foreach ($nasabahData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password123'),
                'is_admin' => false
            ]);

            Nasabah::create([
                'user_id' => $user->id,
                'nama' => $data['name'],
                'alamat' => $data['alamat'],
                'no_telepon' => $data['no_telepon'],
                'saldo' => 0
            ]);
        }
    }
}