<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
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
            return $this->success('Authenticated successfully', $tokenData, 200);

        } catch (AuthenticationException $e) {
            return $this->error($e->getMessage(), 401);
        } catch (ValidationException $e) {
            return $this->error($e->errors(), 400);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), $e->getCode());

        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {

            $user = Auth::user();

            $this->authService->changePassword(
                $user,
                $request->input('current_password'),
                $request->input('new_password')
            );

            return $this->success('Password changed successfully.', null, 200);
        } catch (AuthenticationException $e) {
            return $this->error($e->getMessage(), 401);
        } catch (ValidationException $e) {
            return $this->error($e->errors(), 400);
        } catch (\Throwable $e) {

            return $this->error($e->getMessage(), $e->getCode());

        }
    }
}
