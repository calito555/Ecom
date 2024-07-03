<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\FlutterwaveController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
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

//ROUTE FOR PRODUCT DETAILS
Route::get('product_details/{id}', [UserController::class, 'product_details'])->name('product_details');

//ADDING PRODUCT TO CART ROUTE
Route::post('/addToCart/{id}', [UserController::class, 'addToCart'])->name('addToCart');

//ROUTE TO SHOW OUR CARTS
Route::get('/carts', [UserController::class, 'carts'])->name('carts');

//ROUTE TO DELETE OUR CART
Route::get('/deleteCart/{id}', [UserController::class, 'deleteCart'])->name('deleteCart');

//ROUTE FOR PAY ON DELIVERY
Route::get('/payOndelivery', [UserController::class, 'payOnDelivery'])->name('payOnDelivery');

//ROUTE FOR PROCEED DELIVERY
Route::post('/proceedDelivery', [UserController::class, 'proceedDelivery'])->name('proceedDelivery');



//PRODUCT CATEGORY
Route::get('/productCategory/{id}', [UserController::class, 'productCategory'])->name('productCategory');







//ROUTE TO SEARCH A PARTICULAR PRODUCT EITHER BY NAME, ID, OR CATEGORY
// Route::get('/search', [UserController::class, 'search'])->name('search');





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
    Route::post('addProduct', [AdminController::class, 'addProduct'])->name('addProduct');//post for addProject because of the Form



    //ROUTE TO VIEW ALL THE PRODUCTS CREATED
    Route::get('admin/Products', [AdminController::class, 'Products'])->name('Products');



    //DELETE PRODUCT
    Route::get('/deleteProduct/{id}', [AdminController::class, 'deleteProduct'])->name('deleteProduct');


    //EDIT PRODUCT
    Route::get('/editProduct/{id}', [AdminController::class, 'editProduct'])->name('editProduct');



    //UPDATE PRODUCT
    Route::post('/updateProduct/{id}', [AdminController::class, 'updateProduct'])->name('updateProduct');



    //USER LIST ROUTE
    Route::get('admin/userList', [AdminController::class, 'userList'])->name('userList');


    //PENDING ORDER VIEWS
    Route::get('/pendingOrders', [AdminController::class, 'pendingOrders'])->name('pendingOrders');


    //APPROVE ORDER ROUTE
    Route::get('/approveOrder{id}', [AdminController::class, 'approveOrder'])->name('approveOrder');


    //APPROVE ORDER ROUTE
    Route::get('/disapproveOrder{id}', [AdminController::class, 'disapproveOrder'])->name('disapproveOrder');


    //DELETE USERLIST ROUTE
    Route::get('/deleteUserlist/{id}', [AdminController::class, 'deleteUserlist'])->name('deleteUserlist');


    //ROUTE TO VIEW APPROVED ORDERS
    Route::get('/approvedOrders', [AdminController::class, 'approvedOrders'])->name('approvedOrders');


    //ROUTE TO VIEW CANCELLED ORDERS
    Route::get('/cancelledOrders', [AdminController::class, 'cancelledOrders'])->name('cancelledOrders');
    



   
    //ADMIN LOGOUT
    Route::get('admin_logout', [AdminController::class, 'admin_logout'])->name('admin_logout');


    
});


//FORGET PASSWORD


// Route to return forget password view
Route::get('forgetPassword', [ForgotPasswordController::class, 'forgetPassword'])->name('forgetPassword');

//forgot password post to submit the email
Route::post('forgotPassword', [ForgotPasswordController::class, 'forgotPassword'])->name('forgotPassword.email');

//Route for Confirm code view OR Route to return Confirm code view
Route::get('confirmCode', [ForgotPasswordController::class, 'confirmCode'])->name('confirmCode.email');

//Route for Confirm code to submit code OR Route to Submit Confirmation code from MAILTRAP & DATADASE
Route::post('submitPasswordResetCode', [ForgotPasswordController::class, 'submitPasswordResetCode'])->name('submitPasswordResetCode');


//Route to Reset Password view OR Route to return Reset Password view
Route::get('password_reset', [ForgotPasswordController::class, 'password_reset'])->name('password-reset');


//Route to submit New Password
Route::post('createNewPassword', [ForgotPasswordController::class, 'createNewPassword'])->name('createNewPassword');

//Route to resend Code
Route::get('resend_code/{email}', [ForgotPasswordController::class, 'resend_code'])->name('resend_code');








//FLUTTER WAVE PAYMENT ROUTE
// The page that displays the payment form
Route::get('payment/{grandTotal}', [FlutterwaveController::class, 'payment'])->name('payment');

// The route that the button calls to initialize payment
Route::post('/pay/{grandTotal}', [FlutterwaveController::class, 'initialize'])->name('pay');

// The callback url after a payment
Route::get('/rave/callback', [FlutterwaveController::class, 'callback'])->name('callback');





//USER PROFILE DASHBOARD ROUTE
Route::get('/account', [ProfileController::class, 'account'])->name('account');


//PROFILE ROUTE
Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
Route::post('/saveProfile', [ProfileController::class, 'saveProfile'])->name('saveProfile');


//ROUTE TO UPDATE PASSWORD
Route::get('/update_password', [ProfileController::class, 'update_password'])->name('update_password');
Route::post('/update_user_password', [ProfileController::class, 'updateUserPassword'])->name('updateUserPassword');

