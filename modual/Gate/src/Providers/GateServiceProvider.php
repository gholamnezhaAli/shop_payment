<?php

namespace Gate\Providers;



use App\Repositories\ProductUserRepo;
use Gate\Gate;
use Gate\Repositories\CardRepo;
use Gate\Repositories\PaymentRepo;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class GateServiceProvider extends ServiceProvider
{
    /* protected $namespace = 'Gate\Http\Controllers';*/


    public function register()
    {

        $this->app->singleton("Gate",function (){
            return new Gate();
        });

        $this->app->singleton("PaymentRepo",function (){
            return new PaymentRepo();
        });

        $this->app->singleton("CardRepo",function (){
            return new CardRepo();
        });

        $this->app->singleton("ProductUserRepo",function (){
            return new ProductUserRepo();
        });


    }

    public function boot()
    {

        $this->loadRoutesFrom(__DIR__ . '/../Routes/gate_routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', "Gate");


    }


}

