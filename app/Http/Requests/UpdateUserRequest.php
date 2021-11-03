<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
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
            'user_id' => 'required|integer',
            'name'=> 'max:255',
            'email' => 'email|unique:users',
            'document' => 'required|max:18|min:11',
            'type'=> ['required', Rule::in(['PJ', 'PF'])],
            'password' => 'required|min:6|confirmed',
        ];
    }
}
