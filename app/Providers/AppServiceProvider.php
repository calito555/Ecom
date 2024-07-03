<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
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


            //CHECK THE TOTAL NUMBER OF ITEMS A PARTICULAR USER HAVE IN THE CART TABLE
            if(Auth::user()) {
                $userId = Auth::user()->id;
                $cartCount = Cart::where('userId', $userId)->count();
                $view->with('cartCount', $cartCount);
            }

        });
    }
}
