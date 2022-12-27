<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  true;
    }

    public function rules()
    {
        return [
            "email" => "required|email",
            "password" => "required",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw  new HttpResponseException(response()->json([
            "status" => false,
            "message" => "validation errors",
            "data" => $validator->errors()

        ], 422));
    }
}
