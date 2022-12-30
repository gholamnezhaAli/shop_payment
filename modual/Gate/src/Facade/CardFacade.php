<?php

namespace Gate\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static  getCard($cardNumber, $cvv2)
 * @method static  getCardInventory($cardNumber, $cvv2)
 * @method static  reduceCardInventory($cardNumber, $cardcvv2, $productPrice);
 * @see \Gate\Facade\
 */

class CardFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return "CardRepo";
    }

}
