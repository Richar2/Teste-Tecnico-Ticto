<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

class AdministratorController extends Controller
{
    
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }
    public function login(AuthRequest $request): JsonResponse
    {

        try {
            $credentials = $request->only('email', 'password');

            $tokenData = $this->authService->authenticate($credentials);
            return $this->success('Authenticated successfully',  $tokenData, 200);
        } catch (AuthenticationException $e) {
            return $this->error($e->getMessage(), 401);
        } catch (\Throwable $e) {
            
            dd($e);
            return $this->error($e->getMessage(), $e->getCode());

        }
    }
    


}
