<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
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

        $categories_actived = Category::where('category_status', '1')->orderby('category_name', 'asc')->get();
        $brands_actived = Brand::where('brand_status', '1')->orderby('brand_name', 'asc')->get();
        $product_list = Product::where('product_status', '1')->orderby('product_id', 'desc')->get();
        View::share('categories_actived', $categories_actived);
        View::share('brands_actived', $brands_actived);
        View::share('product_list', $product_list);
    }
}
