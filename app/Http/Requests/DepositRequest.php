<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "user_id" => "required|numeric|exists:users,id",
            "amount" => "required|numeric|min:1"
        ];
    }
    public function messages()
    {
        return [
            'user_id.required' => 'O id do usuário é obrigatório',
            'user_id.numeric' => 'O id do usuário precisa ser numérico',
            'user_id.exists' => 'O usuário precisa estar cadastrado, infelizmente não encontramos nenhum com esse Id',
            'amount.required' => 'O valor a ser depositado é obrigatório',
            'amount.numeric' => 'O valor do depósito precisa ser um número positivo',
            'amount.min' => 'O deposíto mínimo é de R$1,00',
        ];
    }
}