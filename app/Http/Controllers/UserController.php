<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $users = User::whereRaw("tsvectors @@ to_tsquery('english', ?)", [$keyword])
            ->get();

        return view('pages.users.search', ['users' => $users]);
    }
}
