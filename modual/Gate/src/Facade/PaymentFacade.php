<?php

namespace Gate\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static   getUserPayment()
 * @method static   getPayments()
 * @method static   checkPayment($productId, $cardNumber, $cardcvv2, $userId)
 * @method static   newPayment($productId, $userId)
 * =
 * @see \Gate\Facade\
 */
class PaymentFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return "PaymentRepo";
    }

}
