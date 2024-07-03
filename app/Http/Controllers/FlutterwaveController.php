<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use KingFlamez\Rave\Facades\Rave as Flutterwave;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlutterwaveController extends Controller
{
    //
    public function payment($grandTotal) 
    {
        return view('flutterwave.index', compact('grandTotal'));
    }



    public function initialize(Request $request, $grandTotal)
    {
        //This generates a payment reference
        $reference = Flutterwave::generateReference();

        session(['name' => $request->name]);
        session(['email' => $request->email]);
        session(['phone' => $request->phone]);
        session(['address' => $request->address]);

        // Enter the details of the payment
        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => $grandTotal,
            'email' => request()->email,
            'tx_ref' => $reference,
            'currency' => "NGN",
            'redirect_url' => route('callback'),
            'customer' => [
                'email' => request()->email,
                "phone_number" => request()->phone,
                "name" => request()->name,
                "address" =>session('address')
            ],

            "customizations" => [
                "title" => 'Pay for Product',
                "description" => "Payment"
            ]
        ];

        // Assuming you have already defined $data as shown in your question AS DEFINED IN ABOVE ARRAY (daat = [];)
        $payment = Flutterwave::initializePayment($data);


        if ($payment['status'] !== 'success') {
            // notify something went wrong
            return redirect()->route('payment')->with('error', 'Payment initialization fialed, please try again.');
        }


        // Redirect user to Flutterwave payment page
        return redirect($payment['data']['link']);
    }

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback()
    {
        
        $status = request()->status;

        //if payment is successful OR // Ensure transaction verification is successful
        if ($status ==  'successful') {


        $address = session('address');
        $phone = session('phone');

        
        
        $transactionID = Flutterwave::getTransactionIDFromCallback();
        $data = Flutterwave::verifyTransaction($transactionID);


        if(Auth::user())

        {
            $user = Auth::user(); //holding all details of a particular user 
            $authUserId = $user->id; // holding authenticated users ID
            $datas = Cart::where('userId', $authUserId)->get();
            
            foreach($datas as $data){
                $order = new Order();
                $order->name = $data->name;
                $order->email = $data->email;
                $order->address = $address;
                $order->phone = $phone;

                $order->productName = $data->productName;
                $order->productImage = $data->productImage;
                $order->unitPrice = $data->unitPrice;
                $order->totalPrice = $data->totalPrice;
                $order->productQuantity = $data->productQuantity;
                $order->productId = $data->productId;
                $order->userId = $authUserId;
                $order->paymentStatus = "Paid";
                $order->deliveryStatus = "Processing";

                $save = $order->save();


                // Optionally, save payment details to payments table
                $payment = new Payment();
                $payment->phone = session('phone');
                $payment->address = session('address');
                $payment->transactionID = $transactionID;
                $payment->productName = $data->productName;
                $payment->productImage = $data->productImage;
                $payment->productQuantity = $data->productQuantity;
                $payment->unitPrice = $data->unitPrice;
                $payment->totalPrice = $data->totalPrice;

                $payment->paymentStatus = "Paid";
                $payment->deliveryStatus = "Processing";
                $payment->save();

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

        // Save to database (adjust model and table accordingly)
        Payment::create($status);

        // dd($data);
        return redirect()->route('carts')->with('message', 'Transaction was successful, Thank you.');
        }
        elseif ($status ==  'cancelled'){
            //Put desired action/code after transaction has been cancelled here
            return redirect()->route('payment')->with('error', 'Payment have been cancelled');
        }
        else{
            //Put desired action/code after transaction has failed here
            return redirect()->route('payment')->with('error', 'Payment Failed');
        }
        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (including parameters that didn't exist before the transaction is completed. for audit purpose)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here

    }
}
