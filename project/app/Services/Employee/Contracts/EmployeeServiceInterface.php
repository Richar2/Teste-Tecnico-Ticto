<?php

namespace App\Services\Employee\Contracts;

use App\Models\Employee;

interface EmployeeServiceInterface
{
    public function all(): array;
    public function create(array $data): Employee;
    public function update(Employee $employee, array $data): Employee;
    public function delete(Employee $employee): void;
}