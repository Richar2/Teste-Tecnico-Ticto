<?php

namespace App\Services\Address;

use App\Services\Address\Contracts\ViaCepServiceInterface;
use Illuminate\Support\Facades\Http;

class ViaCepService implements ViaCepServiceInterface
{
    public function getAddressByCep(string $cep): array
    {
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if ($response->failed() || isset($response->json()['erro'])) {
            throw new \Exception('CEP inválido ou não encontrado.');
        }

        $data = $response->json();

        return [
            'zip_code' => $data['cep'],
            'street' => $data['logradouro'],
            'neighborhood' => $data['bairro'],
            'city' => $data['localidade'],
            'state' => $data['uf'],
            'complement' => $data['complemento'] ?? '',
        ];
    }
}