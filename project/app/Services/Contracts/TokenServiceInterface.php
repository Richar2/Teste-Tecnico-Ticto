<?php

namespace App\Services\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface TokenServiceInterface
{
    /**
     * Gera token para um usuário autenticável.
     *
     * @param Authenticatable $user
     * @return array
     */
    public function createToken(Authenticatable $user): array;
}