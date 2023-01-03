<?php

namespace Gate\Http\Controllers;


use Carbon\Carbon;

use Dflydev\DotAccessData\Data;
use Gate\Http\Resources\PaymentResource;
use Gate\Facade\PaymentFacade;
use Gate\Http\Requests\PaymentRequest;
use Gate\Models\Payment;
use Gate\Services\VerifyPaymentTimeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PaymentController extends ApiController
{

    public function invalidToken()
    {
        return view("Gate::invalid_token");
    }

    public function successPayment()
    {
        return view("Gate::successPayment");
    }

    public function buy(Request $request)
    {
        $procut_id = $request->product_id;
        $user_id = auth()->id();
        $result = PaymentFacade::createToken();

        if ($result["status"]) {

            PaymentFacade::newPayment($procut_id, $user_id, $result["token"]);

            $link = "http://127.0.0.1:8000/payment/tokens/" . $result["token"];

            return $this->successResponse(201, [
                "link" => $link,
            ], "get  product buy link successfully");


        } else {

            return $this->errorResponse(422, "not crated token successfully");
        }

    }


    public function getPayment($token)
    {


        $payment = PaymentFacade::getPayment($token);


        if (!is_null($payment)) {

            if (PaymentFacade::is_pending($payment->status)) {

                /*$tt = Carbon::createFromFormat('Y-m-d H:i:s', $payment->expire_at)->format('H:i:s');
                   dd($tt);*/


                if (is_array(PaymentFacade::is_expired($payment->expire_at))) {

                    $leftTime = PaymentFacade::is_expired($payment->expire_at)["left_time"];

                    Payment::$time = $leftTime;

                    return view("Gate::payment", compact("token"));


                    /* dd("you have time still", gmdate('H:i:s', $leftTime));*/


                } else {

                    $mess = "your token is expired";

                    return view("Gate::invalid_token", compact("mess"));

                    /* dd("expired", gmdate('H:i:s', $leftTime));*/
                }


                /* dd($currentTime->format("H:i:s"), $expireTime->format("H:i:s"), gmdate('H:i:s', $leftTime));*/


            } else {
                $mess = "your token is " . $payment->status;
                return view("Gate::invalid_token", compact("mess"));

            }

        } else {
            $mess = "token not exist in payment table";

            return view("Gate::invalid_token", compact("mess"));

        }
    }


    public function postPayment(PaymentRequest $request)
    {

        $token = $request->token;
        $cardNumber = $request->card_number;
        $cardcvv2 = $request->cvv2;


        return PaymentFacade::checkPayment($token, $cardNumber, $cardcvv2);

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

    public function updatePayment(Request $request)
    {


        //    return redirect(route("get.payment.invalid.token"));

        $token = $request->token;
        $status = $request->status;

        PaymentFacade::updatePayment($token, $status);

        // $mess = "time out and your payment is failed";

        return response()->json(['route' => route("get.payment.invalid.token")], 200);


    }

}
