<?php

namespace Gate\Http\Requests;

use Carbon\Carbon;
use Gate\Rules\ValidCvv2WithCardNumberRule;
use Gate\Rules\ValidTokenRule;
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
            "token" => ["required","exists:payments,token", new ValidTokenRule()],
            "card_number" => "required|exists:cards,card_number",
            "cvv2" => ["required", "exists:cards,cvv2", new ValidCvv2WithCardNumberRule()],
            'expireTime' => 'required|after:' . Carbon::now()->format('H:i:s'),

        ];

    }
}
