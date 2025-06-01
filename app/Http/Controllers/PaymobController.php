<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use App\Services\PaymobService;

class PaymobController extends Controller
{
    protected $paymobService;

    public function __construct(PaymobService $paymobService)
    {
        $this->paymobService = $paymobService;
    }

    public function credit() 
    {
        $redirectUrl = $this->paymobService->credit();
        return Redirect::away($redirectUrl);
    }

    public function getToken() {
        return $this->paymobService->getToken();
    }

    public function createOrder($tokens) {
        return $this->paymobService->createOrder($tokens);
    }

    public function wallet(Request $request)  
    {
        $redirectUrl = $this->paymobService->wallet($request);
        return Redirect::away($redirectUrl);
    }

    public function checkingOut($payment_method, $integration_id, $order_id, $iframe_id_or_wallet_number): RedirectResponse
    {
        $redirectUrl = $this->paymobService->checkingOut($payment_method, $integration_id, $order_id, $iframe_id_or_wallet_number);
        return Redirect::away($redirectUrl);
    }

    public function getPaymentToken($order, $token)
    {
        return $this->paymobService->getPaymentToken($order, $token);
    }

    public function callback(Request $request)
    {
        //this call back function its return the data from paymob and we show the full response and we checked if hmac is correct means successfull payment

        $data = $request->all();
        ksort($data);
        $hmac = $data['hmac'];
        $array = [
            'amount_cents',
            'created_at',
            'currency',
            'error_occured',
            'has_parent_transaction',
            'id',
            'integration_id',
            'is_3d_secure',
            'is_auth',
            'is_capture',
            'is_refunded',
            'is_standalone_payment',
            'is_voided',
            'order',
            'owner',
            'pending',
            'source_data_pan',
            'source_data_sub_type',
            'source_data_type',
            'success',
        ];
        $connectedString = '';
        foreach ($data as $key => $element) {
            if(in_array($key, $array)) {
                $connectedString .= $element;
            }
        }
        $secret = env('PAYMOB_HMAC');
        $hased = hash_hmac('sha512', $connectedString, $secret);
        if ( $hased == $hmac) {
            //this below data used to get the last order created by the customer and check if its exists to 
            // $todayDate = Carbon::now();
            // $datas = Order::where('user_id',Auth::user()->id)->whereDate('created_at',$todayDate)->orderBy('created_at','desc')->first();
            $status = $data['success'];
            // $pending = $data['pending'];

            if ( $status == "true" ) {

                //here we checked that the success payment is true and we updated the data base and empty the cart and redirct the customer to thankyou page

                // Cart::where('user_id',auth()->user()->id)->delete();
                // $datas->update([
                //     'payment_id' => $data['id'],
                //     'payment_status' => "Compeleted"
                // ]);
                // try {
                //     $order = Order::find($datas->id);
                //     Mail::to('maherfared@gmail.com')->send(new PlaceOrderMailable($order));
                // }catch(\Exception $e){
        
                // }
                return redirect()->route('cart')
                ->with('success', 'Payment Completed, Your Order Is Being Prepared! Delivery Center will contact you from 30-50 Min.');
            }
            else {
                // $datas->update([
                //     'payment_id' => $data['id'],
                //     'payment_status' => "Failed"
                // ]);


                return redirect()->route('cart')->with('message', 'Something Went Wrong Please Try Again');

            }
            
        }else {
            return redirect()->route('cart')->with('message', 'Something Went Wrong Please Try Again');
        }
    }


}

/// USER'S BASE INFO //=====================================
// "first_name"            => $first_name,
// "last_name"             => $last_name,
// "phone_number"          => $user->phone ?: "NA",
// "email"                 => $user->email,
// "apartment"             => "NA",
// "floor"                 => "NA",
// "street"                => $user->address,
// "building"              => "NA",
// "shipping_method"       => "NA",
// "postal_code"           => $user->postal_code,
// "city"                  => $user->city,
// "state"                 => $user->state ?: "NA",
// "country"               => $user->country,
//============================================================