<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

use App\Models\User;
use Carbon\Carbon;


class RegisterController extends Controller
{
    /**
     * Display a login form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    public function showDateOfBirth() : View
    {
        return view('auth.dateofbirth');
    }

    public function updateDateOfBirth(Request $request)
    {
        $request->validate([
            'date_of_birth' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $dateOfBirth = Carbon::parse($value);
                    $minAge = Carbon::now()->subYears(18);
                    if ($dateOfBirth->gt($minAge)) {
                        $fail("You must be at least 18 years old to use the website!");
                    }
                
                    $maxAge = Carbon::now()->subYears(120);
                    if ($dateOfBirth->lt($maxAge)) {
                        $fail("Invalid date of birth!");
                    }
                },
            ],
        ]);

        $user = Auth::user();
        $user->update([
            'date_of_birth' => $request->date_of_birth,
        ]);

        return redirect()->route('home')
            ->withSuccess('You have successfully registered & logged in!');
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:250|unique:users',
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|confirmed|min:6',
            'date_of_birth' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $dateOfBirth = Carbon::parse($value);
                    $minAge = Carbon::now()->subYears(18);
                    if ($dateOfBirth->gt($minAge)) {
                        $fail("You must be at least 18 years old to use the website!");
                    }
                
                    $maxAge = Carbon::now()->subYears(120);
                    if ($dateOfBirth->lt($maxAge)) {
                        $fail("Invalid date of birth!");
                    }
                },
            ],
        ]);


        try {
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
            ]);
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();

        return redirect()->route('home')
            ->withSuccess('You have successfully registered & logged in!');
    }
}
