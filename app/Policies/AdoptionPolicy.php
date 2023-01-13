<?php

namespace App\Policies;

use App\Models\Adoption;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

/*
|-----------------------------------------------------------------------
| Task 1 Authorization.
| You can use to policy for authorize adoptions
|-----------------------------------------------------------------------
*/

class AdoptionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function adopt($user, $adoption){
        //dd($adoption->name);
        if ($adoption->listed_by == null) return true;
        return $user->id != $adoption->listed_by;
    }
}
