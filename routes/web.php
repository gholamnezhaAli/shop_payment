<?php

use App\Http\Controllers\PaymentController;
use Gate\Services\VerifyPaymentTimeService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get("/file", function () {

    dd(\Illuminate\Support\Facades\File::get(public_path("robots.txt")));
});


Route::get("/payment/{productId}/{userId}", [PaymentController::class, "getPayment"])->name("get.payment");

Route::post("/payment", [PaymentController::class, "postPayment"])->name("payment");


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get("/testali", function () {

    /*return MyGate::dosomething();*/

    /* Cache::set("appName","aliGholamnezhad.com",60);

     dd(Cache::get("appName"));*/

    // VerifyPaymentTimeService::store(1, 60);

// dd(VerifyPaymentTimeService::get(1));

    /*    \Gate\Facade\CardFacade*/

    dd(\Gate\Facade\ProductUserFacade::find(1));

});

