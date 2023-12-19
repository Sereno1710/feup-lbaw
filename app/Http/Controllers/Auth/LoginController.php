<?php
 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/home');
        } else {
            return view('auth.login');
        }
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
 
            return redirect()->intended('/home');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')
            ->withSuccess('You have logged out successfully!');
    } 

    public function indexRecoverPassword(){
        return view('auth.recoverpassword');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $google_user = Socialite::driver('google')->stateless()->user();
        $user = User::where('google_id', $google_user->getId())->first();
        
        if (!$user) {

            $new_user = User::create([
                'name' => $google_user->getName(),
                'email' => $google_user->getEmail(),
                'username' => Str::random(12),
                'google_id' => $google_user->getId(),
                'date_of_birth' => '1800-01-01',
            ]);

            Auth::login($new_user);

            return redirect()->intended('dateofbirth');

        } else {
            Auth::login($user);
        }
        if ($user->date_of_birth == '1800-01-01'){
            return redirect()->intended('dateofbirth');
        }
        return redirect()->intended('home');
    }
}

