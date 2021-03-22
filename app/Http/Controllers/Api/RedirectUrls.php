<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RedirectUrls\Create;
use App\Http\Requests\Api\RedirectUrls\Index;
use App\Models\Application;
use App\Models\RedirectUrl;
use Illuminate\Support\Facades\Auth;

class RedirectUrls extends Controller
{

    public function index(Index $request)
    {
        if (Auth::user()->hasPermission('applications')) {
            return abort(403, "you don't have permission to manage applications");
        }
        $redirect_urls = RedirectUrl::whereHas('application', function ($query) {
            return $query->mine();
        });
        return $redirect_urls->get();
    }
    public function create(Create $request)
    {
        if (Auth::user()->hasPermission('applications')) {
            return abort(403, "you don't have permission to manage applications");
        }
        $application = Application::where('user_id', Auth::user()->id)->where('application_id', $request->application_id)->first();
        if (!$application) {
            return abort(404, "application not found");
        }
        $redirect_url = RedirectUrl::create($request->only(['application_id', 'url']));
    }
}
