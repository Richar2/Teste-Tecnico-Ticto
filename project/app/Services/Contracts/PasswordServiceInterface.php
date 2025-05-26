
<?php

namespace App\Services\Contracts;

use App\Models\Employee;

interface PasswordServiceInterface
{
    public function changePassword(Employee $user, string $currentPassword, string $newPassword): void;
}