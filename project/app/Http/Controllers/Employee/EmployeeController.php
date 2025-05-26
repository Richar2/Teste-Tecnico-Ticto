<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Services\Employee\Contracts\EmployeeServiceInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeServiceInterface $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $employees = $this->employeeService->all();
            return $this->success('Employees retrieved successfully.', $employees, 200);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        try {

            $employee = $this->employeeService->create($request->validated());

            return $this->success('Employee created successfully.', $employee, 201);
        } catch (ValidationException $e) {
            return $this->error($e->errors(), 400);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($employee): JsonResponse
    {
        try {
            $employee = Employee::find($employee);
            
            $employee->load('address');
            return $this->success('Employee retrieved successfully.', $employee, 200);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request,  $employee): JsonResponse
    {
        try {
            $employee = Employee::find($employee);
            $employee = $this->employeeService->update($employee, $request->validated());
            return $this->success('Employee updated successfully.', $employee, 200);
        } catch (ValidationException $e) {
            return $this->error($e->errors(), 400);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($employee): JsonResponse
    {
        try {
            $employee = Employee::find($employee);

            if (!$employee) {
                return $this->error('Employee not found.', 404);
            }
    
            $employee = $this->employeeService->delete($employee);
            
            return $this->success('Employee deleted successfully.', null, 204);
        } catch (\Throwable $e) {
            
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}