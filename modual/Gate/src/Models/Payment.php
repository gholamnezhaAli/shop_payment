<?php

namespace Gate\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS_CANCELED = "canceled";
    const STATUS_SUCCESS = "success";
    const STATUS_FAIL = "fail";
    const time = 60 * 5;


    public static function getMinute()
    {
        return self::time / 60;
    }

    public static $statuses =
        [
            self::STATUS_CANCELED,
            self::STATUS_SUCCESS,
            self::STATUS_FAIL
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
