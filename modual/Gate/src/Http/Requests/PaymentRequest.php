<?php

namespace Gate\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            "userId" => "required|integer|exists:users,id",
            "productId" => "required|integer|exists:products,id",
            "card_number" => "required|exists:cards,card_number",
            "cvv2" => "required|exists:cards,cvv2",
            'expireTime' => 'required|after:' . Carbon::now()->format('H:i:s'),

        ];

    }
}
