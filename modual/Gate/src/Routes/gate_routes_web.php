<?php


use Gate\Http\Controllers\HomeController;
use Gate\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get("/payment/{productId}/{userId}", [PaymentController::class, "getPayment"])
    ->name("get.payment")->middleware("web");

Route::post("/payment", [PaymentController::class, "postPayment"])->name("payment")->middleware("web");
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware("web");


Route::get("/test", function () {


//    dd(Productt::find(2));


});
