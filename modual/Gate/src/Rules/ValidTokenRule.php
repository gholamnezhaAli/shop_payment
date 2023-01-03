<?php

namespace Gate\Rules;

use Carbon\Carbon;
use Gate\Facade\CardFacade;
use Gate\Facade\PaymentFacade;
use Gate\Models\Payment;
use Illuminate\Contracts\Validation\Rule;

class ValidTokenRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $token = request()->token;


        $payment = PaymentFacade::getPayment($token);



        $expireTime = $payment->expire_at;
        $expireTime = Carbon::parse($expireTime);


        $currentTime = Carbon::now();
        $currentTime = Carbon::parse($currentTime);


        if (!$currentTime->greaterThan($expireTime)) {

            return true;
        } else {

            return false;
        }


    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'your token in invalid';
    }
}
