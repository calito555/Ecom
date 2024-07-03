<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //

    public function admin_dashboard()
    {
        return view('admin.index');
    }


    //function for CATEGORY
    public function category()
    {
        //$categories = Category::all(); // we can us get,all,first and paginate Categories:: is from our MODEL WE CREATED
        $categories = Category::orderBy('created_at', 'DESC')->paginate(5);
        return view('admin.category', compact('categories'));
    }

    public function add_category(Request $request)
    {
        //VALIDATION OF USER INPUTS
        $validator = $request->validate([
            'category' => 'required|unique:categories,category',
            

        ],[
            //CUSTOMIZED ERROR MESSGAGE
            'category.unique' => 'This category already exists',
        ]);

        Category::create($validator);
        
        return redirect()->back()->with('success', 'Category added successfully');
        
    }


    //DELETING FROM OUR CATEGORIES
    public function deleteCategory($id)
    {
        // dd($id);
        $data = Category::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');

    }



    //CREATE PRODUCT FUNCTION
    public function createProduct(){
        return view('admin.createProduct');
    }


    //ADDING PRODUCT FUNCTION
    public function addProduct(Request $request)
    {
        $request->validate([
            'productName'=>'required|max:255',
            'productCategory'=> 'required|max:255',
            'productImage'=> ['nullable','file', 'max:10000'],
            'productDescription'=> 'required',
            'manufacturerName'=> 'required|max:255',
            'status' => 'required',
            'productPrice' => 'required',
            'discountPrice' => 'nullable',
            'quantity' => 'nullable|max:255',
            'warranty' => 'nullable|max:255',
        ]);

        $product = new Product();
        $product->productName = $request->productName;
        $product->productCategory = $request->productCategory;
        $product->productDescription = $request->productDescription;
        $product->manufacturerName = $request->manufacturerName;
        $product->status = $request->status;
        $product->productPrice = $request->productPrice;
        $product->discountPrice = $request->discountPrice;
        $product->quantity = $request->quantity;
        $product->warranty = $request->warranty;
        $product->featureProduct = $request->featuredProduct;

        //ADDING AN IMAGE
        if ($request->hasFile('productImage')) {
            $image = $request->file('productImage');
            $productImage = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('productFolder'), $productImage);
            $product->productImage = $productImage;
        }

        $product->save();
        return redirect()->back()->with('message', 'Product added successfully');

    }


    public function products()
    {
        return view('admin.products');

    }


    //DELETING PRODUCT
    public function deleteProduct($id)
    {
        // dd($id);
        $deleteProduct = Product::find($id);
        $deleteProduct->delete();
        return redirect()->back()->with('success', 'Product deleted successfully');

    }




    //FUNCTION TO EDIT OUR PRODUCT
    // public function editProduct()
    // {
    //     return view('admin.editProduct');
    // }


    public function editProduct($productId)
    {
        $product = Product::findorFail($productId);
        return view('admin.editProduct', compact('product'));
    }


    
    //FUNCTION TO UPDATE PRODUCT--->>> since we are interacting with a form we make use of REQUEST
    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'productName'=>'required|max:255',
            'productCategory'=> 'required|max:255',
            'productImage'=> ['nullable','file', 'max:10000'],
            'productDescription'=> 'required',
            'manufacturerName'=> 'required|max:255',
            'status' => 'required',
            'productPrice' => 'required',
            'discountPrice' => 'nullable',
            'Quantity' => 'nullable|max:255',
            'warranty' => 'nullable|max:255',
        ]);

        $product = Product::find($id);
        $product->productName = $request->productName;
        $product->productCategory = $request->productCategory;
        $product->productDescription = $request->productDescription;
        $product->manufacturerName = $request->manufacturerName;
        $product->status = $request->status;
        $product->productPrice = $request->productPrice;
        $product->discountPrice = $request->discountPrice;
        $product->quantity = $request->Quantity;
        $product->warranty = $request->warranty;
        $product->featureProduct = $request->featuredProduct;

        //ADDING AN IMAGE
        if ($request->hasFile('productImage')) {
            $image = $request->file('productImage');
            $productImage = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('productFolder'), $productImage);
            $product->productImage = $productImage;
        }

        $product->save();
        return redirect()->route('Products')->with('message', 'Product updated successfully');
    }



    //FUNCTION FOR USERLIST
    public function userList()
    {
        $users = User::where('role_as', '0')->paginate(20);
        return view('admin.user_list', compact('users'));
    }



    //FUNCTION TO DELETE USERLIST
    public function deleteUserlist($id)
    {
        // dd($id);
        $deleteUserlist = User::find($id);
        $deleteUserlist->delete();
        return redirect()->back()->with('success', 'User deleted successfully');

    }




    // FUNCTION FOR PENDING ORDERS
    public function pendingOrders()
    {
        $pendingOrders = Order::where('deliveryStatus', 'Processing')->get();  //$pendingOrders ==> is holding all Orders where Delivery Status is Equal to Processing
        return view('admin.pendingOrders', compact('pendingOrders'));
    }


    //FUNCTION FOR APPROVE ORDER
    public function approveOrder($id)
    {
        //FINDING THE ORDER BY ID
        $order = Order::findorFail($id);

        //SET THE DELIVERY STATUS TO APPROVED
        $order->deliveryStatus = 'Approved';


        //GETTING THE ORDERED QUANTITY AND ASIGNING IT TO A VARIABLE CALLED productQuantity
        $productQuantity = $order->productQuantity;

        //GETTING THE PRODUCT ID FROM ORDER
        $productId = $order->productId;


        //FINDING THE PRODUCTS BY ID
        $product = Product::find($productId);

        //SUBTRACT THE ORDERED QUANTITY FROM THE PRODUCT QUANTITY
        $product->quantity -= $productQuantity;

        //SAVE THE UPDATED PRODCUT QUANTITY
        $product->save();

        //SAVE THE UPDATED ORDER
        $order->save();

        return redirect()->back()->with('message', 'Order has been approved and product quantity updated');
    }


    //FUNCTION TO DISAPPROVE ORDER
    public function disapproveOrder($id)
    {
        $order = Order::findorFail($id);
        $order->deliveryStatus = ('Cancelled');
        $order->save();
        return redirect()->back()->with('message', 'Order have been Cancelled');
    }


    //FUNCTION TO VIEW APPROVED ORDER
    public function approvedOrders()
    {
        $approvedOrders = Order::where('deliveryStatus', 'Approved')->get();
        return view('admin.approvedOrders', compact('approvedOrders'));
    }


    //FUNCTION TO VIEW ALL CANCELLED ORDERS
    public function cancelledOrders()
    {
        $cancelledOrders = Order::where('deliveryStatus', 'Cancelled')->get();
        return view('admin.cancelledOrders', compact('cancelledOrders'));
    }





    //ADMIN LOGOUT FUCTION
    public function admin_logout(){
        Auth::guard('web')->logout(); //LOGOUT IS LARAVEL KEYWORD FOR LOGOUT
        return redirect('/')->with('message', 'You have successfully logged out');

    }
}
