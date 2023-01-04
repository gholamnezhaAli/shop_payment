<?php

namespace Gate\Repositories;


use Carbon\Carbon;
use Gate\Facade\CardFacade;
use Gate\Facade\PaymentFacade;
use Gate\Facade\ProductUserFacade;
use Gate\Models\Card;
use Gate\Models\Payment;
use Gate\Traits\ApiResponse;
use Illuminate\Support\Str;


class PaymentRepo
{
    use ApiResponse;

    private $query;

    public function __construct()
    {
        $this->query = Payment::query();
    }


    public function createToken()
    {
        $token = md5(Str::uuid() . auth()->id() );

        if ($token) return ["status" => true, "token" => $token];
        return ["status" => false, "token" => null];


    }


    public function newPayment($productId, $userId, $token)
    {

        $amount = ProductUserFacade::getProductPrice($productId);
        $status = Payment::STATUS_PENDING;

        $this->query->create([
            "user_id" => $userId,
            "product_id" => $productId,
            "amount" => $amount,
            "token" => $token,
            "expire_at" => Carbon::now()->addMinutes(Payment::getMinute()),
            "status" => $status,
        ]);

    }


    public function getPayment($token)
    {

        return $this->query->where("token", $token)->with(["product", "user"])->first();

    }


    public function getPayments()
    {

        return $this->query->get();

    }


    public function getUserPayment()
    {
        return $this->query->where("user_id", auth()->id())->get();
    }


    public function checkPayment($token, $cardNumber, $cardcvv2)
    {

        $user_id = $this->getPayment($token)->user->id;

        $product_id = $this->getPayment($token)->product->id;


        $is_purchased = $this->is_purchased($user_id, $product_id);


        if (is_null($is_purchased)) {


            $productPrice = ProductUserFacade::getProductPrice($product_id);
            $cardInventory = CardFacade::getCardInventory($cardNumber, $cardcvv2);

            if ($cardInventory > $productPrice) {

                $this->updatePayment($token, Payment::STATUS_SUCCESS);

                ProductUserFacade::reduceProductQuantity($product_id);

                CardFacade::reduceCardInventory($cardNumber, $cardcvv2, $productPrice);

                return response()->json(['message' => 'عملیات پرداخت  با موفقیت انجام شد'], 200);

            } else {

                return response()->json(['message' => 'موجودی حساب شما کمتر از مبلغ محصول هست'], 400);
            }
        } else {

            return response()->json(['message' => 'کاربر این محصول را قبلا خریداری کرده'], 400);

        }
    }


    public function is_purchased($user_id, $product_id)
    {


        return Payment::where("user_id", $user_id)
            ->where("product_id", $product_id)
            ->where("status", Payment::STATUS_SUCCESS)->first();
    }


    public function updatePayment($token, $status)
    {

        Payment::where('token', $token)->update([
            'status' => $status,
        ]);


    }

    public function is_pending($status)
    {

        if (($status === Payment::STATUS_PENDING))
            return true;
        return false;
    }

    public function is_expired($expire_at)
    {

        $expireTime = $expire_at;
        $expireTime = Carbon::parse($expireTime);

        $currentTime = Carbon::now();
        $currentTime = Carbon::parse($currentTime);


        if (!$currentTime->greaterThan($expireTime)) {
            $leftTime = $currentTime->diffInSeconds($expireTime);
            return ["status" => false, "left_time" => $leftTime];
        }
        return true;
    }


}
