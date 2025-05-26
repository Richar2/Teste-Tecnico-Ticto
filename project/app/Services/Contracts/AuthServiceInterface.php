<?php

namespace App\Services\Contracts;



interface AuthServiceInterface
{
    /**
     * Authenticates a user and generates the token
     *
     * @param array $credentials
     * @return array
     */
    public function authenticate(array $credentials): array;
   
}