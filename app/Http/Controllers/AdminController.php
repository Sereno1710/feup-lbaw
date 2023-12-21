<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;   
use App\Models\SystemManager;
use App\Models\User; 
use App\Models\Auction;; 
use App\Models\Report;
use App\Models\moneys; 

class AdminController extends Controller
{
    public function index()
    {
        if($this->authorize('index', Admin::class) or $this->authorize('index', SystemManager::class))
            return getUser();
    }

    public function getUsers()
    {
        if(!$this->authorize('index', Admin::class) or !$this->authorize('index', SystemManager::class))
            return redirect('/')->with('failure', 'You do not have the permissions for this action!');
    
        $users = User::active();
        return view('pages.admin.users', ['users' => $users]);
    }

    public function getAuctions()
    {
        if(!$this->authorize('index', Admin::class) or !$this->authorize('index', SystemManager::class))
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
        $withdrawals = moneys::withdrawals();
        $others = moneys::notPending();
    
        $view = request()->is('admin/transfers/withdrawals') ? 'withdrawals' : 'completed';

        return view("pages.admin.transfers.$view", compact('withdrawals', 'others'));
    }
    

    public function demote(Request $request) 
    {    
        $this->authorize('index', Admin::class);
        if(count(SystemManager::all()) > 1) {
            SystemManager::where(['user_id' => $request->user_id])->delete();
        }

        return redirect('/admin/users')->with('success', 'User demoted successfully!');
    }

    public function promote(Request $request) 
    {    
        $this->authorize('index', Admin::class);
        SystemManager::insert([ 'user_id' => $request->user_id]);

        return redirect('/admin/users')->with('success', 'User promoted successfully!');
    }

    public function disable(Request $request) 
    {
        $this->authorize('index', Admin::class);
        User::where(['id' => $request->user_id])->update(['state' => 'disabled']);
        return redirect('/admin/users')->with('success', 'User disabled successfully!');
    }

    public function ban(Request $request) 
    {
        if(!$this->authorize('index', Admin::class) or !$this->authorize('index', SystemManager::class))
            return redirect('/')->with('failure', 'You do not have the permissions for this action!');
    
        User::where(['id' => $request->user_id])->update(['state' => 'banned']);
        return redirect('/admin/users')->with('success', 'User banned successfully!');
    }  
    
    public function unban(Request $request) 
    {
        if(!$this->authorize('index', Admin::class) or !$this->authorize('index', SystemManager::class))
            return redirect('/')->with('failure', 'You do not have the permissions for this action!');
    
        User::where(['id' => $request->user_id])->update(['state' => 'active']);
        return redirect('/admin/users')->with('success', 'User unbanned successfully!');
    }

    public function reject(Request $request) {
        $this->authorize('index', Admin::class);
        moneys::where(['id' => $request->transfer_id])->update(['state' => 'denied']);
        return redirect('/admin/transfers/withdrawals')->with('success', 'Transfer approved successfully!');
    }

    public function approve(Request $request) {
        $this->authorize('index', Admin::class);
        moneys::where(['id' => $request->transfer_id])->update(['state' => 'accepted']);
        return redirect('/admin/transfers/withdrawals')->with('success', 'Transfer approved successfully!');
    }

    public function approveAuction(Request $request) {
       if(!$this->authorize('index', Admin::class) or !$this->authorize('index', SystemManager::class))
            return redirect('/')->with('failure', 'You do not have the permissions for this action!');
        Auction::where(['id' => $request->auction_id])->update(['state' => 'approved']);
        return redirect('/admin/auctions/pending')->with('success', 'Auction approved successfully!');
    }

    public function rejectAuction(Request $request) {
        if(!$this->authorize('index', Admin::class) or !$this->authorize('index', SystemManager::class))
            return redirect('/')->with('failure', 'You do not have the permissions for this action!');
    
        Auction::where(['id' => $request->auction_id])->update(['state' => 'denied']);
        return redirect('/admin/auctions/pending')->with('success', 'Auction rejected successfully!');
    }

    public function pauseAuction(Request $request) {
        if(!$this->authorize('index', Admin::class) or !$this->authorize('index', SystemManager::class))
            return redirect('/')->with('failure', 'You do not have the permissions for this action!');
    
        Auction::where(['id' => $request->auction_id])->update(['state' => 'paused']);
        return redirect('/admin/auctions/active')->with('success', 'Auction paused successfully!');
    }

    public function resumeAuction(Request $request) {
        if(!$this->authorize('index', Admin::class) or !$this->authorize('index', SystemManager::class))
            return redirect('/')->with('failure', 'You do not have the permissions for this action!');
    
        Auction::where(['id' => $request->auction_id])->update(['state' => 'active']);
        return redirect('/admin/auctions/active')->with('success', 'Auction resumed successfully!');
    }

    public function getReports(Request $request){
        if(!$this->authorize('index', Admin::class) or !$this->authorize('index', SystemManager::class))
        return redirect('/')->with('failure', 'You do not have the permissions for this action!');

        $listed= Report::listed();
        $reviewed=Report::reviewed();

        $view = request()->is('admin/reports/listed') ? 'listed' : 'reviewed';
        return view("pages.admin.reports.$view",compact('listed', 'reviewed'));
    }

    public function reviewReport(Request $request) {
        if(!$this->authorize('index', Admin::class) or !$this->authorize('index', SystemManager::class))
        return redirect('/')->with('failure', 'You do not have the permissions for this action!');


        Report::where(['user_id' => $request->user_id, 'auction_id' => $request->auction_id])->update(['state' => $request->state]);

        return redirect('/admin/reports/listed')->with('success', 'Report updated successefully');
    }

    public function getUserInfo(Request $request, $userId)
    {
        try {
            $user = User::getUserInfo($userId);
    
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
    
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve user info'], 500);
        }
    }
    
    public function updateUserInfo(Request $request)
    {
        $this->authorize('index', Admin::class);

        $user = User::findOrFail($request->id);
        $password = $request->filled('password') ? Hash::make($request->password) : null;
        
        $user->update([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
        ]);
        
        return redirect('/admin/users')->with('success', 'User updated successfully!');
        
    }
}