<?php

namespace Gate\Services;


class VerifyPaymentTimeService
{

    private static $prefix = 'payment_time_';


    public static function store($productId, $time)
    {
        cache()->set(self::$prefix . $productId, $time, $time);
    }

    public static function get($productId)
    {
        return cache()->get(self::$prefix . $productId);
    }

    public static function delete($productId)
    {
        return cache()->delete(self::$prefix . $productId);
    }

    public static function check($productId)
    {
        if (self::get($productId) != $productId) return false;

        self::delete($productId);

        return true;


    }


}
