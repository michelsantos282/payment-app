<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Define the rules of request
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'cpf_cnpj' => 'required|unique:users,cpf_cnpj',
            'password' => 'required',
        ];
    }


    /**
     * @param Validator $validator
     * @return mixed
     */
    public function failedValidation(Validator $validator): mixed
    {
        throw new HttpResponseException(response()->json([
            'message'   => 'Validation errors',
            'status' => 400,
            'data'      => $validator->errors()
        ], 400));
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required',
            'email.unique' => 'Email already exists',
            'email.email' => 'Email is invalid',
            'cpf_cnpj.required' => 'CPF/CNPJ is required',
            'cpf_cnpj.unique' => 'CPF/CNPJ already registered',
            'password.required' => 'Password is required',
        ];
    }
}
