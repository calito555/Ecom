<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/contact', function () {
    return view('contact');
})->name('contact');


Route::get('/signup', function () {
    return view('signup');
});

Route::post('user_logout', [UserController::class, 'user_logout'])->name('user_logout');

//ROUTE TO CREATE A NEW USER (WE ARE CREATING AND INPUTING TO DATABASE=> we use STORE because of name convension since we are storing new user)
Route::post('store', [UserController::class, 'store'])->name('store_user');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//ROUTE FOR THE ADMIN DASHBOARD (ALL ADMIN AND SUBADMIN MUST BE ENCLOSE WITHIN THIS REGION)
Route::middleware(['auth', 'isAdmin'])->group(function(){
    Route::get('admin/dashboard', [AdminController::class, 'admin_dashboard'])->name('admin_dashboard');


    //ROUTE FOR OUR CATEGORY
    Route::get('admin/category', [AdminController::class, 'category'])->name('category');


    //ADDING NEW CATEGORY
    Route::post('add_category', [AdminController::class, 'add_category'])->name('add_category');

    //DELETE CATEGORY
    Route::get('/deleteCategory/{id}', [AdminController::class, 'deleteCategory'])->name('deleteCategory');


    //ROUTE FOR CREATE PRODUCT VIEW
    Route::get('admin/createProduct', [AdminController::class, 'createProduct'])->name('createProduct');


    //ROUTE TO ADD PRODUCT
    Route::post('addProduct', [AdminController::class, 'addProduct'])->name('addProduct');



    //ROUTE TO VIEW ALL THE PRODUCTS CREATED
    Route::get('admin/Products', [AdminController::class, 'Products'])->name('Products');



    //DELETE PRODUCT
    Route::get('/deleteProduct/{id}', [AdminController::class, 'deleteProduct'])->name('deleteProduct');


   
    //ADMIN LOGOUT
    Route::get('admin_logout', [AdminController::class, 'admin_logout'])->name('admin_logout');
});



