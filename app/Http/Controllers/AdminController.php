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
        $this->authorize('index', Admin::class);
        $users = User::activeUsers();
        $admins = User::activeAdmins();
        return view('pages.admin.users', ['users' => $users, 'admins' => $admins]);
    }

    public function getAuctions()
    {
        $this->authorize('index', Admin::class);

        $auctions = Auction::all();
        return view('pages/adminauction', ['auctions' => $auctions]);
    }

    public function getTransfers()
    {
        $this->authorize('index', Admin::class);
        
        $transfers = moneys::pendingTransfers();
        return view('pages/admintransfer', ['transfers' => $transfers]);
    }

    public function demote(Request $request) {
        
        $this->authorize('index', Admin::class);
        if(count(Admin::all()) > 1) {
            Admin::where(['user_id' => $request->user_id])->delete();
        }

        return redirect('/admin/users')->with('success', 'User demoted successfully!');
    }

    public function promote(Request $request) {
        
        $this->authorize('index', Admin::class);
        Admin::insert([ 'user_id' => $request->user_id]);

        return redirect('/admin/users')->with('success', 'User promoted successfully!');
    }

    public function disable(Request $request) {
        $this->authorize('index', Admin::class);
        User::where(['id' => $request->user_id])->update(['is_anonymizing' => true]);
        return redirect('/admin/users')->with('success', 'User promoted successfully!');
    }
}