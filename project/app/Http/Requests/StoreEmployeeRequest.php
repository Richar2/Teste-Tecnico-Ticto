<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Cpf;

class StoreEmployeeRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

 
    public function rules(): array
    {
        return [
            'name'            => 'required|string|max:255',
            'cpf'             => ['required', 'unique:employees,cpf', new Cpf()],
            'email'           => 'required|email|unique:employees,email',
            'password'        => 'required|string|min:8|confirmed',
            'cargo'           => 'required|string|max:100',
            'position'        => 'required|string|max:100',
            'birth_date'      => 'required|date',
            'cep'             => 'required|string|size:8',
        ];
    }

  
    public function messages(): array
    {
        return [
            'name.required'            => 'O nome é obrigatório.',
            'cpf.required'             => 'O CPF é obrigatório.',
            'cpf.unique'               => 'Este CPF já está cadastrado.',
            'email.required'           => 'O e-mail é obrigatório.',
            'email.email'              => 'Informe um e-mail válido.',
            'email.unique'             => 'Este e-mail já está cadastrado.',
            'password.required'        => 'A senha é obrigatória.',
            'password.min'             => 'A senha deve ter no mínimo 8 caracteres.',
            'password.confirmed'       => 'A confirmação da senha não confere.',
            'cargo.required'           => 'O cargo é obrigatório.',
            'birth_date.required'      => 'A data de nascimento é obrigatória.',
            'birth_date.date'          => 'Informe uma data válida.',
            'cep.required'             => 'O CEP é obrigatório.',
            'cep.size'                 => 'O CEP deve conter exatamente 8 dígitos.',
        ];
    }
}