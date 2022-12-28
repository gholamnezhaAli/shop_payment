<?php

namespace Gate\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class GateFacade
 * @method static string doSomething()
 * @see \Gate\Gate
 */
class PaymentFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return "PaymentRepo";
    }

}
