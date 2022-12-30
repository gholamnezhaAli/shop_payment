<?php

namespace Gate\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static  find($productId)
 * @method static  getProductPrice($productId)
 * @method static   getProducts()
 * @method static   newProduct($request)
 * @method static   reduceProductQuantity($productId)

 * @see \Gate\Facade\
 */
class ProductUserFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return "ProductUserRepo";
    }

}
