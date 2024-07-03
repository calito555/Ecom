<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //We are using request because we are getting data from user
    public function store(Request $request){
        //VALIDATION OF USER INPUTS
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|string|unique:users,email|max:255,string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'password' => 'required|min:5|max:40',
            'confirm_password' => 'required|min:5|max:40|same:password',

        ]);

        //IF FORM/VALIDATION FAILS RETURN BACK WITH ERROR MSG
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //PUSHING USER INPUTS TO DATABASE ONCE SUCCESSFUL
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $save = $user->save();
        if($save){
            return redirect()->route('home')->with('message', 'Registration Successful');
        } else {
            return redirect()->back()->with('error', 'Registration failed');
        }

    }

    //LOGOUT
    public function user_logout(){
        Auth::guard('web')->logout(); //LOGOUT IS LARAVEL KEYWORD FOR LOGOUT
        return redirect('/')->with('message', 'You have successfully logged out');

    }


    //FUNCTION FOR OUR PRODUCT DETAILS
    public function product_details($id)
    {
        $data = Product::findorFail($id);
        // dd($data);

        //code to view related products
        $getId = $data->id;
        $getCat = $data->productCategory; //holding product category
        // dd($getCat); 

        $similar = Product::where('productCategory', $getCat)->where('id', '!=', $data->id)->latest()->paginate(4);
        return view('product_details', compact('data', 'similar'));
        // dd($similar); 
    }


    //FUNCTION TO ADD TO CART
    public function addToCart(Request $request, $id)
    {
        if(Auth::id()){

            $user = Auth::user(); //this is holding Authenticated USER
            // dd($user); 
            $product = Product::findorFail($id);  //this is holding product the user want to add to cart
            // dd($product)
            $cart = new Cart();
            $cart->name = $user->name;
            $cart->email = $user->email;
            // $cart->phone = $user->phone;
            $cart->address = $user->address;
            $cart->userId = $user->id;
            $cart->productId = $product->id;
            $cart->productName = $product->productName;

            //CHECK FOR UNITPRICE
            if($product->discountPrice != null){
                $cart->unitPrice = $product->discountPrice;
                $cart->totalPrice = $product->discountPrice * $request->quantity;
            } else{
                $cart->unitPrice = $product->productPrice;
                $cart->totatPrice = $product->productPrice * $request->quantity;
            }

            //CHECK FOR THE NUMBER OF QUANTITY AVAILABLE
            if($product->quantity < $request->quantity){
                return redirect()->back()->with('error', 'The quantity you entered is more than the quantity available');
            } else {
                $cart->productQuantity = $request->quantity;
                $cart->productImage = $product->productImage;
                $cart->save();
            }
            return redirect()->back()->with('message', 'Product added to cart successfully');

        } else {
            return redirect('login');
        }
    }

    public function carts()
    {
       if(Auth::user()){
        $userId = Auth::user()->id; //$userId is holding a particular authenticated user
        // dd($userId);

        $carts = Cart::where('userId', $userId)->get(); //togo  userid where the person Authenticated is the $userId
        return view('carts', compact('carts'));
        // dd($carts);
       } else {
        return redirect('login');
       }
    }


    //DELETING PRODUCT
    public function deleteCart($id)
    {
        // dd($id);
        $deleteCart = Cart::find($id);
        $deleteCart->delete();
        return redirect()->back()->with('success', 'Product deleted successfully');

    }


    //FUNCTION FOR OUR PAYONDELIVERY
    public function payOnDelivery()
    {
        return view('payOnDelivery');
    }



    //FUNCTION FOR OUR PROCEED DELIVERY
    public function proceedDelivery(Request $request)
    {
        $validator = Validator::make($request->all(),[

            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if(Auth::user())

        {
            $user = Auth::user(); //holding all details of a particular user 
            $authUserId = $user->id; // holding authenticated users ID
            $datas = Cart::where('userId', $authUserId)->get();
            
            foreach($datas as $data){
                $order = new Order();
                $order->name = $data->name;
                $order->email = $data->email;
                $order->address = $request->address;
                $order->phone = $request->name;

                $order->productName = $data->productName;
                $order->productImage = $data->productImage;
                $order->unitPrice = $data->unitPrice;
                $order->totalPrice = $data->totalPrice;
                $order->productQuantity = $data->productQuantity;
                $order->productId = $data->productId;
                $order->userId = $authUserId;
                $order->paymentStatus = "Cash on Delivery";
                $order->deliveryStatus = "Processing";

                $save = $order->save();

                //DELETE CART FROM CART TABLE IF SUCCESSFULL
                $cartId = $data->id;
                $cart = Cart::findorFail($cartId);
                $cart->delete();
            }

            if($save){
                return redirect()->route('carts')->with('message', 'Order placed successfully, wait for approval');
            }

        } else {
            return redirect('login');
        }
    }




    //FUNCTION FOR PRODUCT CATEGORY
    public function productCategory($id)
    {
        $categories = Category::all();

        $catId = Category::findorFail($id);
        // dd($catId)

        $catName = $catId->category;
        // dd($catName);

        $productCategories = Product::where('productCategory', $catName)->get(); //$productCategories is the one holding all products by their Categories
        // dd($productCategories) 
        
        $productCount = Product::where('productCategory', $catName)->count();


        return view('productCategory', compact('productCategories', 'catName', 'productCount'));
    }






    //FUNCTION TO SEARCH OUR PRODUCTS
    // public function search(Request $request)
    // {
    //     $query = $request->input('search');

    //     // Perform search logic (e.g., search products based on name or category)
    //     $results = Product::where('productName', 'like', "%$search%")
    //                       ->orWhere('category', 'like', "%$search%")
    //                       ->get();

    //     // Return view with search results
    //     return view('search_results', compact('results'));
    // }


    
}
