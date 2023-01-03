<?php

namespace Gate\Rules;

use Gate\Facade\CardFacade;
use Illuminate\Contracts\Validation\Rule;

class ValidCvv2WithCardNumberRule implements Rule
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
        $cardNumber = request()->card_number;
        $card = CardFacade::getCard($cardNumber, $value);

        if (!is_null($card)) return true;
        return false;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The card number dont  match cvv2';
    }
}
