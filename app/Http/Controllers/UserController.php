<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $followedAuctions = $user->followedAuctions;
        $ownedAuctions = $user->ownAuction;

        return view('pages.profile', ['user' => $user]);
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

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $usersQuery = User::whereRaw("tsvectors @@ to_tsquery('english', ?)", [$keyword . ':*'])
            ->orderByRaw("ts_rank(tsvectors, to_tsquery(?)) DESC", [$keyword]);

        $users = $usersQuery->simplePaginate(9, ['*'], 'page', $request->input('page'));

        return view('pages.users.search', ['users' => $users, 'keyword' => $keyword]);
    }

    public function showProfile($userId)
    {
        $user = User::findOrFail($userId);
        $followedAuctions = $user->followedAuctions;
        $ownedAuctions = $user->ownAuction;
        if ($userId == Auth::id()) {
            return redirect('/profile');
        }
        return view('pages/profile', ['user' => $user, 'followedAuctions' => $followedAuctions, 'ownedAuctions' => $ownedAuctions ]);
    }

    public function delete(Request $request){
        
        $user = Auth::user();

        User::where(['id' => $user->id])->update(['is_anonymizing' => true]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')
            ->withSuccess('You have logged out successfully!');
    }
}
