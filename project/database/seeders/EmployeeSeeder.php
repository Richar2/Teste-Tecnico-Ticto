<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create([
           'public_id' => Str::uuid(),
            'name' => 'Employee Test',
            'email' => 'employee@test.com',
            'cpf' => '98765432100',
            'birth_date' => '1995-05-10',
            'position' => 'Developer', 
            'password' => Hash::make('password123'),
        ]);
    }
}
