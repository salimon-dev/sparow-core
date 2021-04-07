<?php

namespace App\Policies;

use App\Models\RedirectUrl;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RedirectUrlPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RedirectUrl  $redirectUrl
     * @return mixed
     */
    public function update(User $user, RedirectUrl $redirectUrl)
    {
        $application = $redirectUrl->application;
        if (!$application) {
            return Response::deny('application not found', 403);
        }
        if ($application->user_id != $user->id) {
            return Response::deny("you don't have access to application", 403);
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RedirectUrl  $redirectUrl
     * @return mixed
     */
    public function delete(User $user, RedirectUrl $redirectUrl)
    {
        $application = $redirectUrl->application;
        if (!$application) {
            return Response::deny('application not found', 403);
        }
        if ($application->user_id != $user->id) {
            return Response::deny("you don't have access to application", 403);
        }
        return Response::allow();
    }
}
