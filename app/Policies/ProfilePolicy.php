<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;

    public function edit(User $user,Profile $profile)
    {
        $currentUser=$profile->user_id;
        return  $user->id==$currentUser;
    }
}
