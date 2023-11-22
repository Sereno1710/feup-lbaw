<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\moneys;

class BalanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pages/balance', compact('user'));
    }

    public function deposit(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'deposit_amount' => 'required|numeric|min:0',
            'iban_deposit' => ['required', 'regex:/^[A-Z]{2}\d{23}$/'],
        ]);
    
        moneys::create([
            'user_id' => $user->id,
            'amount' => $request->input('deposit_amount'),
            'type' => true, // Deposit
        ]);

        $balance = $user->balance;
        $depositAmount = $request->input('deposit_amount');

        $numericBalance = preg_replace('/[^0-9.]/', '', $balance);

        $numericBalance = (float) $numericBalance;

        $newBalance = $numericBalance + $depositAmount;

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

        moneys::create([
            'user_id' => $user->id,
            'amount' => $request->input('withdraw_amount'),
            'type' => false, // Withdraw
        ]);

        return redirect('/home')->with('success', 'Withdrawal successful!');
    }
}
