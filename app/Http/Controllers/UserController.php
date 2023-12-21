<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Auction;

class UserController extends Controller
{
    public function show($auctionType)
    {
        $user = Auth::user();
        if($auctionType === "followed") {
            $auctions = $user->belongstoMany(Auction::class, 'follows', 'user_id', 'auction_id')->paginate(8);
            $type = "Followed";
        } else if($auctionType === "owned") {
            $auctions = $user->hasMany(Auction::class, 'owner_id')->orderBy('state', 'asc')->paginate(8);
            $type = "Owned";
        }   
        return view('pages.profile', ['user' => $user, 'auctions' => $auctions, 'type' => $type]);
    }

    public function showProfile($userId)
    {
        if ($userId == Auth::id()) {
            return redirect('/profile');
        }
        $user = User::findOrFail($userId);
        $auctions = $user->hasMany(Auction::class, 'owner_id')
            ->where(function ($query) {
                $query->where('state', 'active')->orWhere('state', 'paused')->orWhere('state', 'finished');
            })
            ->orderBy('state', 'asc')->paginate(8);
            $type = "Public";
        
        return view('pages.profile', ['user' => $user, 'auctions' => $auctions, 'type' => $type]);
    }

    public function redirectToProfile()
    {
        return redirect('/profile/followed');
    }

    public function edit()
    {
        $user = Auth::user();

        $this->authorize('update', $user);

        return view('pages/editprofile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $this->authorize('update', $user);

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'required|string',
            'new_password' => 'nullable|string|min:6|confirmed',
            'new_password_confirmation' => 'nullable|string|min:6',
            'biography' => 'nullable|string|max:1000',
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:255',
        ]);

        if ($request->input('email') !== $user->email && User::where('email', $request->input('email'))->exists()) {
            return redirect()->back()->with('error', 'Email is already in use.');
        }

        if ($request->input('username') !== $user->username && User::where('username', $request->input('username'))->exists()) {
            return redirect()->back()->with('error', 'Username is already in use.');
        }

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        if ($request->filled('new_password')) {
            $user->update([
                'password' => Hash::make($request->input('new_password')),
            ]);
        }

        $user->update([
            'username' => $request->input('username'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'biography' => $request->input('biography'),
            'street' => $request->input('street'),
            'city' => $request->input('city'),
            'zip_code' => $request->input('zip_code'),
            'country' => $request->input('country'),
        ]);

        if ($request->hasFile('image')) {
            $existingImagePath = "images/profile/{$user->id}.jpg";
            if (file_exists($existingImagePath)) {
                unlink($existingImagePath);
            }
            $request->file('image')->move('images/profile', "{$user->id}.jpg");
        }

        return redirect('/profile')->with('success', 'Profile updated successfully!');
    }

    

    public function delete(Request $request)
    {


        User::where(['id' => $request->user_id])->update(['state' => 'disabled']);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')
            ->withSuccess('You have deleted your acount successfully!');
    }

    public function profileImagePathJs($request){
        $user = User::findOrFail($request);
        $imagePath = $user->profileImagePath();
        return response()->json(['path' => $imagePath]);
    }

    public function usernameJs($request){
        $user = User::findOrFail($request);
        $name = $user->name;
        return response()->json(['name' => $name]);
    }
}
