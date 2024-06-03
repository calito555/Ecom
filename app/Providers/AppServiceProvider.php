<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\View;
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
        //

        View::composer('*', function($view){

            //FOR ALL PRODUCTS
            $products = Product::orderBy('created_at', 'desc')->paginate(10);
            $view->with('products', $products);


            //CATEGORY LINKS USED THE HOME PAGE HEADER
            $categoryLinks = Category::all();
            $view->with('categoryLinks', $categoryLinks);

        });
    }
}
