<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Brand;
use App\Models\Category;
use Schema;

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
        Schema::defaultStringLength(200);
        $category_list = Category::orderby('category_name', 'asc')->get();
        $brand_list = Brand::orderby('brand_name', 'asc')->get();
        View::share('category_list', $category_list);
        View::share('brand_list', $brand_list);
    }
}
