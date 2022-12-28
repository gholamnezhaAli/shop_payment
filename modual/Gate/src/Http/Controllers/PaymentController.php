<?php

namespace Gate\Http\Controllers;


use App\Http\Resources\PaymentResource;
use Gate\Http\Requests\PaymentRequest;
use Gate\Models\Payment;
use Gate\Repositories\CardRepo;
use Gate\Repositories\PaymentRepo;
use Gate\Repositories\ProductUserRepo;
use Gate\Services\VerifyPaymentTimeService;
use Illuminate\Http\Request;


class PaymentController extends ApiController
{

    public function getPayment($productId, $userId)
    {

        VerifyPaymentTimeService::store($userId, Payment::time);

        $leftTime = VerifyPaymentTimeService::get($userId);


        return view("Gate::payment", compact("leftTime", "productId", 'userId'));

    }

    public function postPayment(PaymentRequest $request, PaymentRepo $paymentRepo)
    {

        $productId = $request->productId;
        $cardNumber = $request->card_number;
        $cardcvv2 = $request->cvv2;
        $userId = $request->userId;


        if (VerifyPaymentTimeService::get($userId) === null) {
            return response()->json(['message' => 'زمان '.\Gate\Models\Payment::getMinute().' دقیقه شما به پایان رسیده', "data" => $userId], 400);
        }

        return $paymentRepo->checkPayment($productId, $cardNumber, $cardcvv2, $userId);

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
