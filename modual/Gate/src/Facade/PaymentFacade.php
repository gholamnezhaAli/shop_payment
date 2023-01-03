<?php

namespace Gate\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static getUserPayment()
 * @method static getPayments()
 * @method static getPayment($token)
 * @method static checkPayment($productId, $cardNumber, $cardcvv2)
 * @method static newPayment($productId, $userId, $tokenId)
 * @method static updatePayment($token,$status)
 * @method static createToken()
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
