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

    public function accessDateOfBirth(User $user)
    {
        return $user->date_of_birth == '1800-01-01';
    }
}