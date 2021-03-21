<?php

namespace App\Policies;

use App\Models\RedirectUrl;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RedirectUrlPolicy
{
    use HandlesAuthorization;
    private function checkUserPermission(User $user)
    {
        $permission = Permission::where('user_id', $user->id)->where('scope', 'applications')->first();
        if (!$permission) {
            return Response::deny("you don't have permission to applications", 403);
        }
        return true;
    }
    private function checkApplicationPermission(User $user, Application $application)
    {
        if ($application->user_id == $user->id) {
            return true;
        } else {
            return Response::deny("you don't have access to this application", 403);
        }
    }
    /**
     * Determine whether the user can search in applications or not
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        $user_permission_result = $this->checkUserPermission($user);
        if ($user_permission_result !== true) {
            return $user_permission_result;
        }
        return Response::allow();
    }
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RedirectUrl  $redirectUrl
     * @return mixed
     */
    public function view(User $user, RedirectUrl $redirectUrl)
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
