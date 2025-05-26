<?php

namespace App\Http\Controllers;

use App\Services\Address\Contracts\ViaCepServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller
{
    protected $viaCepService;

    public function __construct(ViaCepServiceInterface $viaCepService)
    {
        $this->viaCepService = $viaCepService;
    }

    /**
     * Consulta endereço pelo CEP.
     */
    public function getAddressByCep(Request $request): JsonResponse
    {
        $request->validate([
            'cep' => 'required|string|size:8'
        ]);

        try {
            $address = $this->viaCepService->getAddressByCep($request->input('cep'));
            return $this->success('Endereço encontrado com sucesso.', $address, 200);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 400);
        }
    }
}