<?php

namespace Gate\Services;


class VerifyPaymentTimeService
{

    private static $prefix = 'payment_time_';


    public static function store($userId, $time)
    {
        cache()->set(self::$prefix . $userId, $userId, $time);
    }

    public static function get($userId)
    {
        return cache()->get(self::$prefix . $userId);
    }

    public static function delete($userId)
    {
        return cache()->delete(self::$prefix . $userId);
    }

    public static function check($userId)
    {

      if (cache()->has(self::$prefix . $userId)) {
            self::delete($userId);
            return true;
        }
        return false;

       /* if (self::get($userId) != $userId) return false;

        self::delete($userId);

        return true;*/


    }


}
