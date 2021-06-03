<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
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
        view()->composer('backend/layouts/master', function ($view) {
            $view->with('menus', Menu::menus());
        });

        view()->composer('backend/layouts/master', function ($view) {
            $view->with('permission', Menu::getPermissionHasRoles(Auth::user()->rol_id));
        });

        view()->composer('frontend/layouts/master', function ($view) {
            $view->with('user', Auth::user());
        });

        #The paginator now uses the Tailwind CSS framework for its default styling
        Paginator::useBootstrap();
    }
}
