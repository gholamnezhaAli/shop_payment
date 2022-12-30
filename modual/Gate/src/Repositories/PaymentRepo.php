<?php

namespace Gate\Repositories;


use Carbon\Carbon;
use Gate\Facade\CardFacade;
use Gate\Facade\PaymentFacade;
use Gate\Facade\ProductUserFacade;
use Gate\Models\Payment;


class PaymentRepo
{

    private $query;

    public function __construct()
    {
        $this->query = Payment::query();
    }

    public function newPayment($productId, $userId)
    {

        $amount = ProductUserFacade::getProductPrice($productId);
        $invoice_id = Carbon::now()->microsecond;
        $status = Payment::STATUS_SUCCESS;

        $this->query->create([
            "user_id" => $userId,
            "product_id" => $productId,
            "amount" => $amount,
            "invoice_id" => $invoice_id,
            "status" => $status,
        ]);

    }

    public function getPayments()
    {

        return $this->query->get();

    }

    public function getUserPayment()
    {

        return $this->query->where("user_id", auth()->id())->get();

    }

    public function checkPayment($productId, $cardNumber, $cardcvv2, $userId)
    {


        $is_purchased = $this->is_purchased($userId, $productId);

        if ($is_purchased)
            return response()->json(['message' => 'کاربر این محصول را قبلا خریداری کرده'], 400);


        $is_product = ProductUserFacade::find($productId);
        $is_card = CardFacade::getCard($cardNumber, $cardcvv2);


        if ($is_product && $is_card) {

            $productPrice = ProductUserFacade::getProductPrice($productId);
            $cardInventory = CardFacade::getCardInventory($cardNumber, $cardcvv2);

            if ($cardInventory > $productPrice) {

                PaymentFacade::newPayment($productId, $userId);
                ProductUserFacade::reduceProductQuantity($productId);
                CardFacade::reduceCardInventory($cardNumber, $cardcvv2, $productPrice);


                return response()->json(['message' => 'عملیات پرداخت  با موفقیت انجام شد'], 400);
            } else {
                return response()->json(['message' => 'موجودی حساب شما کمتر از مبلغ محصول هست'], 400);
            }
        } else {
            return response()->json(['message' => 'اطلاعات کارت شما اشتباه هست'], 400);
        }

    }

    public function is_purchased($user_id, $product_id)
    {
        return $this->query->where("user_id", $user_id)
            ->where("product_id", $product_id)
            ->where("status", Payment::STATUS_SUCCESS)->first();
    }


}
