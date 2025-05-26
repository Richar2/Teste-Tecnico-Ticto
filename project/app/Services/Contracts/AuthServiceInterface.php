<?php

namespace App\Services\Contracts;

use App\Models\Employee;

interface AuthServiceInterface
{
    /**
     * Authenticates a user and generates the token
     *
     * @param array $credentials
     * @return array
     */
    public function authenticate(array $credentials): array;
    public function changePassword(Employee $user, string $currentPassword, string $newPassword): void;
}