<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Plain\Login as LoginRequest;
use App\Http\Requests\Api\Plain\Register as RegisterRequest;
use App\Http\Resources\Profile as Profile;
use App\Models\Application;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class Plain extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::whereUsername($request->username)->wherePassword(md5($request->password))->first();
        if (!$user)
            return abort(401);
        else {
            $token = null;
            if ($request->has('application_token')) {
                $application = Application::where('public_token', $request->application_token)->firstOrFail();
                $token = $user->customCreateToken($request->input('application', 'direct'), $request->input('scopes', []), $application->id, $request->userAgent(), $request->ip());
            } else {
                $token = $user->customCreateToken($request->input('application', 'direct'), $request->input('scopes', []), null, $request->userAgent(), $request->ip());
            }
            return new Profile($user, [
                'access_token' => $token->accessToken,
                'expires_at' => $token->token->expires_at->timestamp,
            ]);
        }
    }
    public function register(RegisterRequest $request)
    {
        $user = new User;
        $user->fill($request->only(['username', 'phone', 'email', 'first_name', 'last_name']));
        $user->password = md5($request->password);
        if ($request->hasFile('avatar')) {
            $avatar = Storage::disk('arvan-s3')->put('/avatars', $request->file('avatar'));
            $user->avatar = $avatar;
        }
        $user->save();
        $token = $user->customCreateToken($request->input('application', 'direct'), $request->input("scopes", []), null, $request->userAgent(), $request->ip());
        Permission::create([
            "user_id" => $user->id,
            "scope" => "applications",
        ]);
        return new Profile($user, [
            'access_token' => $token->accessToken,
            'expires_at' => $token->token->expires_at->timestamp,
        ]);
    }
}
