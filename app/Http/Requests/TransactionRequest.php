<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransactionRequest extends FormRequest
{
    /**
     * Define the rules of request
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'payer_id' => 'required|integer|exists:users,id',
            'payee_id' => 'required|integer|exists:users,id',
            'amount' => 'required|gt:0',
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
            'payer_id.required' => 'Payer id is required',
            'payee_id.required' => 'Payee id is required',
            'amount.required' => 'Amount is required',
            'payer_id.integer' => 'Payer id should be an integer',
            'payee_id.integer' => 'Payee id should be an integer',
            'amount.gt' => 'Amount should be greater than 0',
            'payer_id.exists' => 'Payer id not found',
            'payee_id.exists' => 'Payee id  not found',
        ];
    }
}
