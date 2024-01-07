<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\moneys;


class StripeController extends Controller
{
    public function checkout()
    {
        return view('pages.balance');
    }

    public function deposit(Request $request)
    {

        $depositAmount = $request->input('deposit_amount');
        $request->validate([
            'deposit_amount' => 'required|numeric|min:1',
        ]);

        \Stripe\Stripe::setApiKey(config('stripe.sk'));

        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name' => 'Deposit',
                        ],
                        'unit_amount'  => $depositAmount * 100,
                    ],
                    'quantity'   => 1,
                ],
            ],
            'mode'        => 'payment',
            'success_url' => route('success', ['depositAmount' => $depositAmount]),
            'cancel_url'  => route('checkout'),
        ]);

        return redirect()->away($session->url);
    }

    public function success($depositAmount)
    {
        $user = Auth::user();

        $newMoneys = moneys::create([
            'user_id' => $user->id,
            'amount' => $depositAmount,
            'type' => true, // Deposit
        ]);
        moneys::where(['id' => $newMoneys->id])->update(['state' => 'accepted']);
        
        return redirect('/home')->with('message', 'The deposit was successful');
    }
}