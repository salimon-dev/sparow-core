<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Plain\Login as LoginRequest;
use App\Http\Requests\Api\Plain\Register as RegisterRequest;
use App\Http\Resources\Profile;
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
            $token = $user->createToken('example client');
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
            $user->avatar = Storage::disk('arvan-s3')->put('/avatars', $request->file('avatar'));
        }
        $user->save();
        $token = $user->createToken('example client');
        return new Profile($user, [
            'access_token' => $token->accessToken,
            'expires_at' => $token->token->expires_at->timestamp,
        ]);
    }
}
