<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaymobService
{
    public function credit()
    {
        $tokens = $this->getToken();
        $order = $this->createOrder($tokens);
        $paymentToken = $this->getPaymentToken($order, $tokens);
        return 'https://accept.paymob.com/api/acceptance/iframes/'.env('PAYMOB_IFRAME_ID').'?payment_token='.$paymentToken;
    }

    public function getToken()
    {
        $response = Http::post('https://accept.paymob.com/api/auth/tokens', [
            'api_key' => env('PAYMOB_API_KEY')
        ]);
        return $response->object()->token;
    }

    public function createOrder($tokens)
    {
        $total = 100;
        $items = [
            [ "name"=> "ASC1515",
                "amount_cents"=> "500000",
                "description"=> "Smart Watch",
                "quantity"=> "1"
            ],
            [
                "name"=> "ERT6565",
                "amount_cents"=> "200000",
                "description"=> "Power Bank",
                "quantity"=> "1"
            ]
        ];
        $data = [
            "auth_token" =>   $tokens,
            "delivery_needed" =>"false",
            "amount_cents"=> $total*100,
            "currency"=> "EGP",
            "items"=> $items,
        ];
        $response = Http::post('https://accept.paymob.com/api/ecommerce/orders', $data);
        return $response->object();
    }

    public function wallet(Request $request)
    {
        return $this->checkingOut(
            'paymob_mobile_wallet_payment',
            env('PAYMOB_MOBILE_WALLET_INTEGRATION_ID'),
            '00100',
            "01095304064"
        );
    }

    public function checkingOut($payment_method, $integration_id, $order_id, $iframe_id_or_wallet_number)
    {
        $response = Http::withHeaders([
            'content-type' => 'application/json'
        ])->post('https://accept.paymobsolutions.com/api/auth/tokens',[
            "api_key"=> env('PAYMOB_API_KEY')
        ]);
        $json=$response->json();
        $response_final=Http::withHeaders([
            'content-type' => 'application/json'
        ])->post('https://accept.paymobsolutions.com/api/ecommerce/orders',[
            "auth_token"=>$json['token'],
            "delivery_needed"=>"false",
            "amount_cents"=>100,
            "merchant_order_id" => 15
        ]);
        $json_final=$response_final->json();
        $user = Auth::user();
        $name = $user->name;
        if ((count(explode(" ",$name)) == 1)) {
            $first_name = $name;$last_name=$name;
        } else {
            $first_name = explode(" ",$name)[0];
            $last_name = explode(" ",$name)[1];
        }
        $response_final_final=Http::withHeaders([
            'content-type' => 'application/json'
        ])->post('https://accept.paymobsolutions.com/api/acceptance/payment_keys',[
            "auth_token"=>$json['token'],
            "expiration"=> 36000,
            "amount_cents"=> 1000,
            "order_id"=>$order_id,
            "billing_data"=>[
                "first_name" => "MTest",
                "last_name" => "KTest",
                "phone_number" => "NA",
                "email" => "test@example.com",
                "apartment" => "NA",
                "floor" => "NA",
                "street" => "New Maadi",
                "building" => "NA",
                "shipping_method" => "NA",
                "postal_code" => "75275",
                "city" => "Cairo",
                "state" => "Maadi",
                "country" => "Egypt"
            ],
            "currency"=>"EGP",
            "integration_id"=>$integration_id
        ]);
        $response_final_final_json=$response_final_final->json();
        if ($payment_method == 'paymob_mobile_wallet_payment') {
            $response_iframe =Http::withHeaders([
                'content-type' => 'application/json'
            ])->post('https://accept.paymob.com/api/acceptance/payments/pay',[
                "source"=>[
                    "identifier"=> $iframe_id_or_wallet_number,
                    "subtype"=> "WALLET"
                ],
                "payment_token"=>$response_final_final_json['token'],
            ]);
            return $response_iframe->json()['redirect_url'];
        } else {
            return 'https://accept.paymobsolutions.com/api/acceptance/iframes/'. $iframe_id_or_wallet_number .'?payment_token=' . $response_final_final_json['token'];
        }
    }

    public function getPaymentToken($order, $token)
    {
        $billingData = [
            "apartment" => '45',
            "email" => "newmail@gmai.com",
            "floor" => '5',
            "first_name" => 'maher',
            "street" => "NA",
            "building" => "NA",
            "phone_number" => '0123456789',
            "shipping_method" => "NA",
            "postal_code" => "NA",
            "city" => "cairo",
            "country" => "NA",
            "last_name" => "fared",
            "state" => "NA"
        ];
        $data = [
            "auth_token" => $token,
            "amount_cents" => 100*100,
            "expiration" => 3600,
            "order_id" => $order->id,
            "billing_data" => $billingData,
            "currency" => "EGP",
            "integration_id" => env('PAYMOB_INTEGRATION_ID')
        ];
        $response = Http::post('https://accept.paymob.com/api/acceptance/payment_keys', $data);
        return $response->object()->token;
    }
} 