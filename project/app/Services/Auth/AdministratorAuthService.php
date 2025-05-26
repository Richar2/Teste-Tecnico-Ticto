<?php

namespace App\Services\Auth;

use App\Models\Administrator;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\TokenServiceInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\AuthenticationException;

class AdministratorAuthService implements AuthServiceInterface
{
    protected $tokenService;

    public function __construct(TokenServiceInterface $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function authenticate(array $credentials): array
    {
        $admin = Administrator::where('email', $credentials['email'])->first();

        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            throw new AuthenticationException('Unauthorized');
        }

        return $this->tokenService->createToken($admin);
    }
}