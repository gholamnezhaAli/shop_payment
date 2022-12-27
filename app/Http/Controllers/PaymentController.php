<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\ProductResource;
use App\Repositories\CardRepo;
use App\Repositories\PaymentRepo;
use App\Repositories\ProductUserRepo;
use App\Services\VerifyPaymentTimeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentController extends ApiController
{

    public function getPayment($productId, $userId)
    {
        VerifyPaymentTimeService::store($productId, 5);
        $leftTime = VerifyPaymentTimeService::get($productId);

        return view("payment", compact("leftTime", "productId", 'userId'));

    }

    public function postPayment(PaymentRequest $request, ProductUserRepo $productUserRepo, CardRepo $cardRepo, PaymentRepo $paymentRepo)
    {

//
//        return response()->json(['message' => 'عملیات با موفقیت انجام شد', "data" => $request->all()], Response::HTTP_OK);


        $productId = $request->productId;
        $cardNumber = $request->card_number;
        $cardcvv2 = $request->cvv2;
        $userId = $request->userId;

        if (VerifyPaymentTimeService::check($productId)) {
            session()->flash("message", "زمان 1 دقیقه شما به پایان رسیده ");
            return back();
        }

        if ($productUserRepo->find($productId) && $cardRepo->getCard($cardNumber, $cardcvv2)) {
            $productPrice = $productUserRepo->getProductPrice($productId);
            $cardInventory = $cardRepo->getCardInventory($cardNumber, $cardcvv2);

            if ($cardInventory > $productPrice) {

                $paymentRepo->newPayment($productId, $userId);
                session()->flash("message", "تراکنش شما با موفقیت انجام شد ");
                return back();
            } else {
                session()->flash("message", "موجودی حساب شما کمتر از مبلغ محصول هست ");
                return back();
            }

        } else {

            session()->flash("message", "اطلاعات کارت شما اشتباه هست ");
            return back();
        }

    }


    public function getPayments(PaymentRepo $paymentRepo)
    {

        $payments = $paymentRepo->getPayments();
        return $this->successResponse(201, [
            "products" => $payments,
        ], "get  payments successfully");

    }

    public function getUserPayments(PaymentRepo $paymentRepo)
    {

//        $userPayments = $paymentRepo->getUserPayment();
//
//
//        return $this->successResponse(201, [
//            "userPayments" => PaymentResource::collection($userPayments),
//        ], "get user payments successfully");


    }

}
