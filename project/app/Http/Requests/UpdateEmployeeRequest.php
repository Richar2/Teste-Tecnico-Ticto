<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Cpf;

class UpdateEmployeeRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true; 
    }
    public function rules(): array
    {
        $employeeId = $this->route('employee')->id ?? null;

        return [
            'name' => 'sometimes|required|string|max:255',
            'cpf' => ['sometimes', 'required', new Cpf(), "unique:employees,cpf,{$employeeId}"],
            'email' => ["sometimes", "required", "email", "unique:employees,email,{$employeeId}"],
            'password' => 'sometimes|nullable|string|min:8|confirmed',
            'cargo' => 'sometimes|required|string|max:100',
            'data_nascimento' => 'sometimes|required|date',
            'cep' => 'sometimes|required|string|size:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
            'cargo.required' => 'O cargo é obrigatório.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.date' => 'Informe uma data válida.',
            'cep.required' => 'O CEP é obrigatório.',
            'cep.size' => 'O CEP deve conter exatamente 8 dígitos.',
        ];
    }
}