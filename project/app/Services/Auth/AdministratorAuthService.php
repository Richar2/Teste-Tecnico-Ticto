<?php

namespace App\Services;

use App\Models\Administrator;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\TokenServiceInterface;
use Illuminate\Support\Facades\Auth;
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
        if (!Auth::guard('administrator')->attempt($credentials)) {
            throw new AuthenticationException('Unauthorized');
        }

        /** @var Administrator $admin */
        $admin = Auth::guard('administrator')->user();

        return $this->tokenService->createToken($admin);
    }
}