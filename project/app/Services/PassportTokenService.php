<?php

namespace App\Services;

use App\Services\Contracts\TokenServiceInterface;
use Illuminate\Contracts\Auth\Authenticatable;

class PassportTokenService implements TokenServiceInterface
{
    public function createToken(Authenticatable $user): array
    {
        $tokenResult = $user->createToken('Personal Access Token');

        return [
            'token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $tokenResult->token->expires_at
        ];
    }
}