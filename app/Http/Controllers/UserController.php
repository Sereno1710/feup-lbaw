<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function changeUsername(Request $request)
    {
        $user = Auth::user();
        $user->username = $request->input('new_username');
        $user->save();

        return redirect()->back()->with('success', 'Username updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    public function changeEmail(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'new_email' => 'required|email|unique:users,email',
        ]);

        $user->email = $request->input('new_email');
        $user->save();

        return redirect()->back()->with('success', 'Email updated successfully.');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $users = User::whereRaw("tsvectors @@ to_tsquery('english', ?)", [$keyword])
            ->get();

        return view('pages.users.search', ['users' => $users]);
    }
}
