<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libreria\MenuBuilder;
use Auth;


class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(MenuBuilder::class, function($app){
            return new MenuBuilder(Auth::user()->funcionario);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
