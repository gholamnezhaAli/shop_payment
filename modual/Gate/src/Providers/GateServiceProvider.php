<?php

namespace Gate\Providers;


use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class GateServiceProvider extends ServiceProvider
{
    /* protected $namespace = 'Gate\Http\Controllers';*/


    public function register()
    {


    }

    public function boot()
    {

        $this->loadRoutesFrom(__DIR__ . '/../Routes/gate_routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', "Gate");


    }


}

