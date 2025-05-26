<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Administrator::create([
            'public_id' => Str::uuid(),
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'cpf' => '12345678900',
            'birth_date' => '1990-01-01',
            'password' => Hash::make('password123'),
        ]);
    }
}
