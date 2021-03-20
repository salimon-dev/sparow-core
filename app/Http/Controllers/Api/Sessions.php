<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Session;
use App\Models\Passport\Token;
use Auth;
use Illuminate\Http\Request;

class Sessions extends Controller
{
    public function list(Request $request)
    {
        return Session::collection(Auth::user()->tokens()->paginate());
    }
    public function delete(Request $request, Token $token)
    {
        $token->delete();
        return 'ok';
    }
    public function deleteAllButMe(Request $request)
    {
        $current_token = Auth::user()->token();
        Auth::user()->tokens()->where('id', '<>', $current_token->id)->delete();
        return 'ok';
    }
}
