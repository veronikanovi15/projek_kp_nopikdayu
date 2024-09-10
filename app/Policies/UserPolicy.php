<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\Models\User  $authUser
     * @param  \App\Models\User  $user
     * @return mixed
     */
   // app/Policies/UserPolicy.php
public function update(User $authUser, User $user)
{
    return $authUser->role === 'admin' || $authUser->id === $user->id;
}

public function delete(User $authUser, User $user)
{
    \Log::info("Authorization check: Auth User ID: " . $authUser->id . ", User ID: " . $user->id);
    \Log::info("Auth User Role: " . $authUser->role);
    \Log::info("Policy Result: " . ($authUser->role === 'admin' || $authUser->id === $user->id ? 'Allowed' : 'Denied'));

    return $authUser->role === 'admin' || $authUser->id === $user->id;
}



}

