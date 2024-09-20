<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //only add above- use View, Here website.master is view directory of resources
        View::composer(['website.master'], function ($view){
            $view->with('categories',Category::all());
        });
    }
}
