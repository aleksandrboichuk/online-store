<?php

namespace App\Providers;
use App\View\Composers\BasicPageDataComposer;
use App\View\Composers\MenuComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer([
            '*'
        ], BasicPageDataComposer::class);

        View::composer([
            'layouts.*'
        ], MenuComposer::class);
    }
}
