<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Mail\RecoverPassword;


class MailController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if ($user) { 
            $newPassword = Str::random(12);

            $mailData = [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $newPassword,
            ];

            $user->update([
                'password' => Hash::make($newPassword),
            ]);
        
            Mail::to($request->email)->send(new RecoverPassword($mailData));
        
            return redirect()->route('login')->with('success', 'Mail sent successfully!');
            
        } else {
            return redirect()->back()->with('error', 'User not found for the email provided.');
        }
    }
}