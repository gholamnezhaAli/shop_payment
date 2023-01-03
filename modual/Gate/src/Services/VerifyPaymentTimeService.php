<?php

namespace Gate\Services;


use Carbon\Carbon;

class VerifyPaymentTimeService
{



    private static $prefix = '_verify_code_';


    public static function generate()
    {
        return Carbon::now()->timestamp;

    }

    public static function store($token, $code, $time)
    {
        cache()->put(self::$prefix . $token, $code, $time);
    }

    public static function get($token)
    {
        return cache()->get(self::$prefix . $token);
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
