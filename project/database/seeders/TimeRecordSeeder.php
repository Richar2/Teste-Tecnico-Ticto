<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TimeRecord;
use App\Models\Employee;
use Illuminate\Support\Str;

class TimeRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employee = Employee::first();

        $records = [
            [
                'type' => 'entrada',
                'description' => 'Entrada no expediente',
                'recorded_at' => now()->setTime(8, 0, 0)
            ],
            [
                'type' => 'saida',
                'description' => 'Saída para almoço',
                'recorded_at' => now()->setTime(12, 0, 0)
            ],
            [
                'type' => 'entrada',
                'description' => 'Retorno do almoço',
                'recorded_at' => now()->setTime(13, 0, 0)
            ],
            [
                'type' => 'saida',
                'description' => 'Saída do expediente',
                'recorded_at' => now()->setTime(17, 0, 0)
            ]
        ];

        foreach ($records as $record) {
            TimeRecord::create([
                'public_id' => Str::uuid(),
                'employee_id' => $employee->id,
                'recorded_at' => $record['recorded_at'],
                'type' => $record['type'],
                'description' => $record['description']
            ]);
        }
    }
    }
}
