<?php

namespace Gate\Models;

use App\Models\User;
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

    public static $time = 60 * 1;
    public static $token;


    public static function getMinute()
    {
         return static::$time / 60;

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


}
