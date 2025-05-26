<?php

namespace App\Services\Address\Contracts;

interface ViaCepServiceInterface
{
    public function getAddressByCep(string $cep): array;
}