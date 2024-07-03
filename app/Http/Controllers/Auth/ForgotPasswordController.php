<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Ramsey\Uuid\v1;

// use SebastianBergmann\Comparator\Exception;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    // use SendsPasswordResetEmails;

    protected function forgetPassword()
    {
        return view('auth.passwords.forget-password');
    }



    function sendMail($email, $code)
    {
        // Preparing the email data
        $data = array(
            'body' => $code,
        );

        // Defining the email view
        $view = 'email.password_reset';

        // Sending the email
        try {
            Mail::send($view, $data, function ($message) use ($email) {
                $message->to($email, 'Shopwise')->subject('Shopwise Reset Password Notification'); //from the receipant
                $message->from('shopwisesupport@gmail.com', 'Shopwise'); //sendser
            });
        } catch (Exception $th) {
            return false;
        }
    }






    // first step
    protected function forgotPassword(Request $request)
    {
        $activation_code = random_int(100000, 999999);



        // finding the user by email
        $user = User::where("email", $request->email)->first();  //go to our user table in our database WGERE email is equal to the inputed email and must be the first

        if ($user) {
            $user->update(['activation_code' => $activation_code]);
            $this->sendMail($user->email, $activation_code);

            return redirect()->route('confirmCode.email', ["user_email" => $user->email]);//user_email here is serving as key here
        } else {
            return redirect()->route('forgetPassword')->with('error', 'Invalid Email');
        }
    }


    //second Step
    //FUNCTION TO RESET CONFIRM CODE
    protected function confirmCode()
    {
        return view("auth.passwords.confirm_code", ["email" => request()->user_email]);//user_email here is serving as value here
    }


    //Third Step
    //FUNCTION TO RESET PASSWORD
    protected function submitPasswordResetCode(Request $request)
    {
        $code = $request->code;
        $email = $request->user_email;
        $account = User::where('email', $email)->first() ?? false;
        if($account){
            if($code == $account->activation_code){
                return redirect()->route('password-reset', ["user_email" => $email]);
            } else {
                return redirect()->route('confirmCode.email', ["user_email" => $email])->with('error', 'Invalide Code');
            }
        } else {
            return redirect()->back()->with('error', 'Account not found');
        }

    }


    // Fourth Step
    protected function password_reset()
    {
        return view("auth.passwords.reset-password", ["email" => request()->user_email]);
    }


    //Fifth Step
    //FUNCTION TO CREATE NEW PASSWORD
    protected function createNewPassword(Request $request)
    {
        if($request->password !== $request->confirm_password){
            return redirect()->back()->with('error', 'Password Mismatch');
        } else {
            $password = Hash::make($request->password);
            $user = User::where("email", $request->user_email)->first();
            $user->update(['password' => $password]);
            return redirect()->route('login');
        }
    }



    //Last Step
    public function resend_code($email)
    {
        $activation_code = random_int(100000, 999999);



        // finding the user by email
        $user = User::where("email", $email)->first();  //go to our user table in our database WHERE email is equal to the email 

        if ($user) {
            $user->update(['activation_code' => $activation_code]);
            $this->sendMail($user->email, $activation_code);

            return redirect()->route('confirmCode.email', ["user_email" => $user->email])->with('message', 'Code Resent');
        } else {
            return redirect()->route('forgetPassword')->with('error', 'Invalid Email');
        }

    }
}