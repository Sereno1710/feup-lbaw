<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $user)
    {
        return $user->id === auth()->user()->id;
    }

    public function over18(String $then){
        $then= strtotime($then);
        $min = strtotime('+18 years', $then);
        if(time() < $min)  {
            return false;
        }
        return true;
    }
}