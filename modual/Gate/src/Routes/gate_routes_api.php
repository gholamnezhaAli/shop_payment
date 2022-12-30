<?php


use Gate\Http\Controllers\PaymentController;
use Gate\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;




Route::get("api/payments", [PaymentController::class, "getPayments"]);

Route::prefix("api/admin")->middleware("auth:api")->group(function () {


    Route::apiResource("products", ProductController::class);
    Route::get("/payment/user", [PaymentController::class, "getUserPayments"]);



});
