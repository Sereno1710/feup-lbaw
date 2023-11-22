<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
   
use App\Models\Admin;   
use App\Models\User; 
use App\Models\Auction;; 
use App\Models\Report;
use App\Models\moneys; 

class AdminController extends Controller
{
    public function index()
    {
        $this->authorize('index', Admin::class);
        return view('pages/admin');
    }

    public function getUsers()
    {
        $users = User::activeUsers();
        return view('pages/adminuser', ['users' => $users]);
    }
}