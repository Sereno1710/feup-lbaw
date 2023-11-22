<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller
{
    public function index()
    {
        return view('pages/profile');
    }

    public function edit()
    {
        $user = Auth::user();

        return view('pages/editprofile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->update([
            'username' => $request->input('username'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->filled('password') ? Hash::make($request->input('password')) : $user->password,
            'street' => $request->input('street'),
            'city' => $request->input('city'),
            'zip_code' => $request->input('zip_code'),
            'country' => $request->input('country'),
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images', 'public');
            $user->update(['image' => $imagePath]);
        }

        return redirect('/profile')->with('success', 'Profile updated successfully!');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $users = User::whereRaw("LOWER(username) LIKE LOWER(?)", ['%' . $keyword . '%'])
            ->orWhereRaw("LOWER(name) LIKE LOWER(?)", ['%' . $keyword . '%'])
            ->orderByRaw("ts_rank(tsvectors, to_tsquery('english', ?)) DESC", [$keyword])
            ->get();

        return view('pages.users.search', ['users' => $users]);
    }

    public function showProfile($userId)
    {
        $user = User::findOrFail($userId);
        if ($userId == Auth::id()){
            return redirect('/profile');
        }
        return view('pages/profile', ['user' => $user]);
    }
}
