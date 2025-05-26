<?php

namespace App\Services\Auth;

use App\Models\Employee;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\TokenServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class EmployeeAuthService implements AuthServiceInterface
{
    protected $tokenService;

    public function __construct(TokenServiceInterface $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function authenticate(array $credentials): array
    {
        
        
        $employee = Employee::where('email', $credentials['email'])->first();

        if (!$employee || !Hash::check($credentials['password'], $employee->password)) {
            throw new AuthenticationException('Unauthorized');
        }
        
        return $this->tokenService->createToken($employee);
    }
}