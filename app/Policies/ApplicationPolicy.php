<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ApplicationPolicy
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
        $permission = Permission::where('user_id', $user->id)->where('scope', 'applications')->first();
        if (!$permission) {
            return Response::deny("you don't have permission to applications", 403);
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can edit the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return mixed
     */
    public function edit(User $user, Application $application)
    {
        if ($application->user_id == $user->id) {
            return true;
        } else {
            return Response::deny("you don't have access to this application", 403);
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return mixed
     */
    public function delete(User $user, Application $application)
    {
        if ($application->user_id == $user->id) {
            return true;
        } else {
            return Response::deny("you don't have access to this application", 403);
        }
        return Response::allow();
    }
}
