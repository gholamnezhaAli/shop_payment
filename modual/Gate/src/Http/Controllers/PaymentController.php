<?php

namespace Gate\Http\Controllers;


use App\Http\Resources\PaymentResource;
use Gate\Facade\PaymentFacade;
use Gate\Http\Requests\PaymentRequest;
use Gate\Models\Payment;
use Gate\Repositories\PaymentRepo;
use Gate\Services\VerifyPaymentTimeService;
use Illuminate\Support\Facades\Route;


class PaymentController extends ApiController
{

    public function getPayment($productId, $userId)
    {

        VerifyPaymentTimeService::store($userId, Payment::time);

        return view("Gate::payment", compact("productId", 'userId'));

    }

    public function postPayment(PaymentRequest $request)
    {


        $productId = $request->productId;
        $cardNumber = $request->card_number;
        $cardcvv2 = $request->cvv2;
        $userId = $request->userId;


        if (VerifyPaymentTimeService::get($userId) === null) {

            return response()->json(['message' => 'زمان ' . Payment::getMinute() . ' دقیقه شما به پایان رسیده', "data" => $userId], 400);
        }

        return PaymentFacade::checkPayment($productId, $cardNumber, $cardcvv2, $userId);

    }


    public function getPayments()
    {

        $payments = PaymentFacade::getPayments();
        return $this->successResponse(201, [
            "products" => $payments,
        ], "get  payments successfully");

    }

    public function getUserPayments()
    {

        $userPayments = PaymentFacade::getUserPayment();


        return $this->successResponse(201, [
            "userPayments" => PaymentResource::collection($userPayments),
        ], "get user payments successfully");


    }

}
