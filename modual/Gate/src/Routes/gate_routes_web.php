<?php


use Gate\Http\Controllers\HomeController;
use Gate\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get("/payment/tokens/{token}", [PaymentController::class, "getPayment"])
    ->name("get.payment")->middleware("web");


Route::get("/payment/invalid_token", [PaymentController::class, "invalidToken"])
    ->name("get.payment.invalid.token")->middleware("web");

Route::get("/payment/success_payment", [PaymentController::class, "successPayment"])
    ->name("get.payment.success")->middleware("web");


Route::post("/payment/update", [PaymentController::class, "updatePayment"])
    ->name("post.payment.update")->middleware("web");


Route::post("/payment", [PaymentController::class, "postPayment"])->name("payment")->middleware("web");

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware("web");


Route::get("/test", function () {

    $decimal = 1.9;

   // $hours = floor($decimal / 60);
    $minutes = floor($decimal % 60);
    $seconds = $decimal - (int)$decimal;
    $seconds = round($seconds * 60);

   // return str_pad($hours, 2, "0", STR_PAD_LEFT) . ":" . str_pad($minutes, 2, "0", STR_PAD_LEFT) . ":" . str_pad($seconds, 2, "0", STR_PAD_LEFT);
    return   str_pad($minutes, 2, "0", STR_PAD_LEFT) . ":" . str_pad($seconds, 2, "0", STR_PAD_LEFT);


});
