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
        $auctions1 = Auction::noActions();
        $auctions2 = Auction::active();
        return view('pages.admin.auctions', ['auctions1' => $auctions1, 'auctions2' => $auctions2]);
    }

    public function getTransfers()
    {
        $this->authorize('index', Admin::class);
        
        $deposits = moneys::deposits();
        $withdrawals = moneys::withdrawals();
        $others = moneys::notPending();
        return view('pages.admin.transfers', ['deposits' => $deposits, 'withdrawals' => $withdrawals, 'others' => $others]);
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

    public function approve(Request $request) {
        $this->authorize('index', Admin::class);
        moneys::where(['id' => $request->id])->update(['state' => 'accepted']);
        return redirect('/admin/transfers')->with('success', 'Transfer approved successfully!');
    }

    public function reject(Request $request) {
        $this->authorize('index', Admin::class);
        moneys::where(['id' => $request->id])->update(['state' => 'denied']);
        return redirect('/admin/transfers')->with('success', 'Transfer rejected successfully!');
    }

    public function approveAuction(Request $request) {
        $this->authorize('index', Admin::class);
        Auction::where(['id' => $request->id])->update(['state' => 'approved']);
        return redirect('/admin/auctions')->with('success', 'Auction approved successfully!');
    }

    public function rejectAuction(Request $request) {
        $this->authorize('index', Admin::class);
        Auction::where(['id' => $request->id])->update(['state' => 'denied']);
        return redirect('/admin/auctions')->with('success', 'Auction rejected successfully!');
    }

    public function pauseAuction(Request $request) {
        $this->authorize('index', Admin::class);
        Auction::where(['id' => $request->id])->update(['state' => 'paused']);
        return redirect('/admin/auctions')->with('success', 'Auction paused successfully!');
    }

    public function resumeAuction(Request $request) {
        $this->authorize('index', Admin::class);
        Auction::where(['id' => $request->id])->update(['state' => 'active']);
        return redirect('/admin/auctions')->with('success', 'Auction resumed successfully!');
    }

    public function disableAuction(Request $request) {
        $this->authorize('index', Admin::class);
        Auction::where(['id' => $request->id])->update(['state' => 'disabled']);
        return redirect('/admin/auctions')->with('success', 'Auction disabled successfully!');
    }
}