<?php

namespace Gate\Providers;


use Gate\Repositories\CardRepo;
use Gate\Repositories\PaymentRepo;
use Gate\Repositories\ProductUserRepo;
use Illuminate\Support\ServiceProvider;

class GateServiceProvider extends ServiceProvider
{

    public function register()
    {


        $this->app->singleton("PaymentRepo", function () {
            return new PaymentRepo();
        });

        $this->app->singleton("CardRepo", function () {
            return new CardRepo();
        });

        $this->app->singleton("ProductUserRepo", function () {
            return new ProductUserRepo();
        });


    }

    public function boot()
    {

        $this->loadRoutesFrom(__DIR__ . '/../Routes/gate_routes_web.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/gate_routes_api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', "Gate");


    }


}

