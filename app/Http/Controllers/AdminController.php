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
        return getUser();
    }

    public function getUsers()
    {
        if(!$this->authorize('index', Admin::class) or !$this->authorize('index',SystemManager::class)) 
            return redirect('/')->with('failure', 'You do not have the permissions for this action!');
        $users = User::active();
        return view('pages.admin.users', ['users' => $users]);
    }

    public function getAuctions()
    {
        if(!$this->authorize('index', Admin::class) or !$this->authorize('index',SystemManager::class)) 
            return redirect('/')->with('failure', 'You do not have the permissions for this action!');
           
        $active = Auction::active();
        $pending = Auction::pending();
        $others = Auction::others();

        $view = request()->is('admin/auctions/active') ? 'active' :
        (request()->is('admin/auctions/pending') ? 'pending' : 'others');

        return view("pages.admin.auctions.$view", compact('active', 'pending', 'others'));
    }

    public function getTransfers()
    {
        if(!$this->authorize('index', Admin::class))
            return redirect('/')->with('failure', 'You do not have the permissions for this action!');
    
        $deposits = moneys::deposits();
        $withdrawals = moneys::withdrawals();
        $others = moneys::notPending();
    
        $view = request()->is('admin/transfers/deposits') ? 'deposits' :
                (request()->is('admin/transfers/withdrawals') ? 'withdrawals' : 'completed');

        return view("pages.admin.transfers.$view", compact('deposits', 'withdrawals', 'others'));
    }
    

    public function demote(Request $request) 
    {    
        $this->authorize('index', Admin::class);
        if(count(Admin::all()) > 1) {
            Admin::where(['user_id' => $request->user_id])->delete();
        }

        return redirect('/admin/users')->with('success', 'User demoted successfully!');
    }

    public function promote(Request $request) 
    {    
        $this->authorize('index', Admin::class);
        Admin::insert([ 'user_id' => $request->user_id]);

        return redirect('/admin/users')->with('success', 'User promoted successfully!');
    }

    public function disable(Request $request) 
    {
        $this->authorize('index', Admin::class);
        User::where(['id' => $request->user_id])->update(['is_anonymizing' => true]);
        return redirect('/admin/users')->with('success', 'User promoted successfully!');
    }

    public function reject(Request $request) {
        $this->authorize('index', Admin::class);
        moneys::where(['id' => $request->id])->update(['state' => 'denied']);
        $view = $request->view;
        return redirect('/admin/transfers/'.$view)->with('success', 'Transfer rejected successfully!');
    }

    public function approve(Request $request) {
        $this->authorize('index', Admin::class);
        moneys::where(['id' => $request->id])->update(['state' => 'accepted']);
        $view = $request->view;
        return redirect('/admin/transfers/'.$view)->with('success', 'Transfer approved successfully!');
    }

    public function approveAuction(Request $request) {
        $this->authorize('index', Admin::class);
        Auction::where(['id' => $request->id])->update(['state' => 'approved']);
        return redirect('/admin/auctions/pending')->with('success', 'Auction approved successfully!');
    }

    public function rejectAuction(Request $request) {
        $this->authorize('index', Admin::class);
        Auction::where(['id' => $request->id])->update(['state' => 'denied']);
        return redirect('/admin/auctions/pending')->with('success', 'Auction rejected successfully!');
    }

    public function pauseAuction(Request $request) {
        $this->authorize('index', Admin::class);
        Auction::where(['id' => $request->id])->update(['state' => 'paused']);
        return redirect('/admin/auctions/active')->with('success', 'Auction paused successfully!');
    }

    public function resumeAuction(Request $request) {
        $this->authorize('index', Admin::class);
        Auction::where(['id' => $request->id])->update(['state' => 'active']);
        return redirect('/admin/auctions/active')->with('success', 'Auction resumed successfully!');
    }

    public function disableAuction(Request $request) {
        $this->authorize('index', Admin::class);
        Auction::where(['id' => $request->id])->update(['state' => 'disabled']);
        return redirect('/admin/auctions/active')->with('success', 'Auction disabled successfully!');
    }
}