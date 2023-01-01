<?php

namespace App\Providers;

use App\Models\Genre;
use App\Models\Menu;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(199);

        \View::Composer('admin.layouts.partials._main_menu', function($view) {
            $Menu = new Menu();
            $menus = $Menu->getInstance('admin');
//            $menus->clearCache();
            $view->with(compact('menus'));
        });


        \View::composer('front.layouts.main', function ($view) {
            $view->with('genres', Genre::all());
        });
    }
}
