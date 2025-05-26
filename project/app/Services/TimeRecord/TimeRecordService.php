<?php
namespace App\Services\TimeRecord;

use App\Models\Employee;
use App\Models\TimeRecord;
use Illuminate\Support\Str;

class TimeRecordService
{
    public function record(Employee $employee, string $type = 'entrada', ?string $description = null): TimeRecord
    {
        return TimeRecord::create([
            'public_id'   => Str::uuid(),
            'employee_id' => $employee->id,
            'recorded_at' => now(),
            'type'        => $type,
            'description' => $description
        ]);
    }
}
