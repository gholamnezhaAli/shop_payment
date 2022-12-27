<?php


use Gate\Http\Controllers\HomeController;
use Gate\Http\Controllers\PaymentController;

Route::get("/payment/{productId}/{userId}", [PaymentController::class, "getPayment"])
    ->name("get.payment")->middleware("web");

Route::post("/payment", [PaymentController::class, "postPayment"])->name("payment")->middleware("web");
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware("web");
