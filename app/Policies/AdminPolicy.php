<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function index() {
        return Auth::check() && Auth::user()->isAdmin();
    }   
}