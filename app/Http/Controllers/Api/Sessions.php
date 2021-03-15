<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateProfile;
use App\Http\Resources\Profile as ResourcesProfile;
use App\Jobs\ProfileUpdated;
use App\Models\Passport\Token;
use Auth;
use Illuminate\Http\Request;

class Sessions extends Controller
{
    public function list(Request $request)
    {
        $tokens = Token::whereUserId(Auth::user()->id)->get();
        return $tokens;
    }
    public function update(UpdateProfile $request)
    {
        $user = Auth::user();
        $user->fill($request->only(['username', 'email', 'phone', 'first_name', 'last_name']));
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        if ($user->isDirty('phone')) {
            $user->phone_verified_at = null;
        }
        if ($request->has('password')) {
            $user->password = md5($request->password);
        }
        if ($request->hasFile('avatar')) {
            Storage::disk('arvan-s3')->delete($user->avatar);
            $user->avatar = Storage::disk('arvan-s3')->put('/avatars', $request->file('avatar'));
        }
        $user->save();
        dispatch(new ProfileUpdated($user->id));
        return ResourcesProfile::make($user);
    }
    public function logout()
    {
        Auth::user()->token()->delete();
        return 'ok';
    }
}
