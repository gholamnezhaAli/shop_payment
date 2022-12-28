<?php

namespace Gate\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class GateFacade
 * @method static string doSomething()
 * @see \Gate\Gate
 */
class CardFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return "CardRepo";
    }

}
