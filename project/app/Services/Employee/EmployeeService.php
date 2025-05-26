<?php

namespace App\Services\Employee;

use App\Models\Employee;
use App\Models\Address;
use App\Services\Employee\Contracts\EmployeeServiceInterface;
use App\Services\Address\Contracts\ViaCepServiceInterface;
use Illuminate\Support\Facades\Hash;

class EmployeeService implements EmployeeServiceInterface
{
    protected $viaCepService;

    public function __construct(ViaCepServiceInterface $viaCepService)
    {
        $this->viaCepService = $viaCepService;
    }
    
    public function all(): array
    {
        return Employee::with('address')->get()->toArray();
    }

    public function create(array $data): Employee
    {
        $addressData = $this->getAddressByCep($data['cep']);

        $data['password'] = Hash::make($data['password']);
        unset($data['cep']); 

        $employee = Employee::create($data);

        $employee->address()->create($addressData);

        return $employee;
    }

    public function update(Employee $employee, array $data): Employee
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
    
        if (isset($data['cep'])) {
            $addressData = $this->viaCepService->getAddressByCep($data['cep']);
    
     
            if ($employee->address) {
                $employee->address()->update($addressData);
            } else {
                $employee->address()->create($addressData);
            }
    
            unset($data['cep']);
        }
    
        $employee->update($data);
    
        return $employee;
    }

    public function delete(Employee $employee): void
    {
        $employee->address()->delete();
        $employee->delete();
        
    }

    private function getAddressByCep(string $cep): array
    {
        return $this->viaCepService->getAddressByCep($cep);
    }
}