<?php

namespace App\Services\Auth;

use App\Models\Employee;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\TokenServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
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

    public function changePassword(Employee $user, string $currentPassword, string $newPassword): void
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['A senha atual está incorreta.'],
            ]);
        }
    
        $user->password = Hash::make($newPassword);
        $user->save();
    }
}