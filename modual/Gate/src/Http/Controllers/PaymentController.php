<?php

namespace Gate\Http\Controllers;



use App\Http\Resources\PaymentResource;
use Gate\Http\Requests\PaymentRequest;
use Gate\Repositories\CardRepo;
use Gate\Repositories\PaymentRepo;
use Gate\Repositories\ProductUserRepo;
use Gate\Services\VerifyPaymentTimeService;
use Illuminate\Http\Request;


class PaymentController extends ApiController
{

    public function getPayment($productId, $userId)
    {

        VerifyPaymentTimeService::store($userId, 60);

        $leftTime = VerifyPaymentTimeService::get($userId);


        return view("Gate::payment", compact("leftTime", "productId", 'userId'));

    }

    public function postPayment(PaymentRequest $request, ProductUserRepo $productUserRepo, CardRepo $cardRepo, PaymentRepo $paymentRepo)
    {


        $productId = $request->productId;
        $cardNumber = $request->card_number;
        $cardcvv2 = $request->cvv2;
        $userId = $request->userId;


        if (!VerifyPaymentTimeService::get($userId)) {

            return response()->json(['message' => 'زمان 1 دقیقه شما به پایان رسیده', "data" => $userId], 400);

        }

        if ($productUserRepo->find($productId) && $cardRepo->getCard($cardNumber, $cardcvv2)) {
            $productPrice = $productUserRepo->getProductPrice($productId);
            $cardInventory = $cardRepo->getCardInventory($cardNumber, $cardcvv2);

            if ($cardInventory > $productPrice) {

                $paymentRepo->newPayment($productId, $userId);
                return response()->json(['message' => 'عملیات پرداخت  با موفقیت انجام شد', "data" => $request->all()], 400);
            } else {
                return response()->json(['message' => 'موجودی حساب شما کمتر از مبلغ محصول هست', "data" => $request->all()], 400);
            }
        } else {
            return response()->json(['message' => 'اطلاعات کارت شما اشتباه هست', "data" => $request->all()], 400);
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

        $userPayments = $paymentRepo->getUserPayment();


        return $this->successResponse(201, [
            "userPayments" => PaymentResource::collection($userPayments),
        ], "get user payments successfully");


    }

}
