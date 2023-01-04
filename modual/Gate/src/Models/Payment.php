<?php

namespace Gate\Models;

use App\Models\User;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS_PENDING = "pending";
    const STATUS_CANCELED = "canceled";
    const STATUS_SUCCESS = "success";
    const STATUS_FAIL = "fail";

    public static $time = 60 * 5;
    public static $token;


    public static function getMinute()
    {


        return static::$time / 60;

       /* $decimal = static::$time;

       $hours = floor($decimal / 60);
        $minutes = floor($decimal % 60);
        $seconds = $decimal - (int)$decimal;
        $seconds = round($seconds * 60);

        return  str_pad($minutes, 2, "0", STR_PAD_LEFT) . ":" . str_pad($seconds, 2, "0", STR_PAD_LEFT);*/





    }


    public static $statuses =
        [
            self::STATUS_CANCELED,
            self::STATUS_SUCCESS,
            self::STATUS_FAIL,
            self::STATUS_PENDING

        ];


    public function user()
    {
        return $this->belongsTo(User::class);

    }

    public function product()
    {
        return $this->belongsTo(Product::class);

    }

    public function setExpiredAtAttribute()
    {
        $this->attributes["expired_at"] = now();
    }

}
