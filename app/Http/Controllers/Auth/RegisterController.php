<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Display a login form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Register a new user.
     */
     public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:250',
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|confirmed',
            'date_of_birth' => 'required|date',
        ]);
        
        $birth= $request->date_of_birth;

        if(!$this->autherize('over18', $birth)){
            return redirect()->back()->with('error', 'Must be over 18 to register!');
        }

        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'balance' => 0,
            'date_of_birth' => $request->date_of_birth,
            'biography' => null,
            'street' => null,
            'city' => null,
            'zip_code' => null,
            'country' => null,
            'rating' => null,
            'image' => null, 
        ]);


        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
    
        return redirect()->route('home')
            ->withSuccess('You have successfully registered & logged in!');
    }
}
