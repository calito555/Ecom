<?php

namespace App\Http\Controllers;

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
}
