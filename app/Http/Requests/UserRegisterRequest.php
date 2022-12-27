<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest
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
            "name" => "required|string|min:3|max:20",
            "email" => "required|email|unique:users,email",
            "password" => "required",
            "c_password" => "required|same:password",
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
