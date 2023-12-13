<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;

use App\Models\SystemManager;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SystemManagerPolicy
{
    use HandlesAuthorization;

    public function index() {
        return Auth::check() && Auth::user()->isSystemManager();
    }   
}