<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pages/balance', compact('user'));
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'deposit_amount' => 'required|numeric|min:0',
            'iban_deposit' => ['required', 'regex:/^[A-Z]{2}\d{23}$/'],
        ]);
    


        $balance = $user->balance;
        $depositAmount = $request->input('deposit_amount');

        $numericBalance = preg_replace('/[^0-9.]/', '', $balance);

        $numericBalance = (float) $numericBalance;

        $newBalance = $numericBalance - $depositAmount;

        $user->update([
            'balance' => $newBalance,
        ]);

        return redirect('/home')->with('success', 'Deposit successful!');
    }

    public function withdraw(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'withdraw_amount' => 'required|numeric|min:0',
            'iban_withdraw' => ['required', 'regex:/^[A-Z]{2}\d{23}$/'],
        ]);

        $balance = $user->balance;
        $withdrawAmount = $request->input('withdraw_amount');

        $numericBalance = preg_replace('/[^0-9.]/', '', $balance);

        $numericBalance = (float) $numericBalance;

        $newBalance = $numericBalance - $withdrawAmount;

        if ($newBalance < 0) {
            return back()->withErrors(['withdraw_amount' => 'Insufficient funds!'])->withInput();
        }

        $user->update([
            'balance' => $newBalance,
        ]);

        return redirect('/home')->with('success', 'Withdrawal successful!');
    }
}
