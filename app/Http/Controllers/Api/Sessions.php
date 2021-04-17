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
        $tokens = Auth::user()->tokens();
        if ($request->exists("current") && $request->current) { // return current token
            $current_token = Auth::user()->token();
            $tokens = $tokens->where('id', $current_token->id);
        }
        if ($request->exists("others") && $request->others) { // return other tokens
            $current_token = Auth::user()->token();
            $tokens = $tokens->where('id', "<>", $current_token->id);
        }
        return Session::collection($tokens->paginate($request->input("pageSize", 15)));
    }
    public function delete(Request $request, Token $token)
    {
        $current_token = Auth::user()->token();
        if ($token->id == $current_token->id) {
            return abort(403, "you can't remove your current token");
        }
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
