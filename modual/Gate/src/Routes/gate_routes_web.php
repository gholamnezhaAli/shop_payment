<?php


use Gate\Http\Controllers\HomeController;
use Gate\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get("/payment/tokens/{token}", [PaymentController::class, "getPayment"])
    ->name("get.payment")->middleware("web");


Route::get("/payment/invalid_token", [PaymentController::class, "invalidToken"])
    ->name("get.payment.invalid.token")->middleware("web");


Route::post("/payment/update", [PaymentController::class, "updatePayment"])
    ->name("post.payment.update")->middleware("web");


Route::post("/payment", [PaymentController::class, "postPayment"])->name("payment")->middleware("web");

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware("web");


Route::get("/test", function () {


//    dd(Productt::find(2));


});
