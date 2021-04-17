<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RedirectUrls\Create;
use App\Http\Requests\Api\RedirectUrls\Edit;
use App\Http\Requests\Api\RedirectUrls\Index;
use App\Http\Resources\RedirectUrl as ResourcesRedirectUrl;
use App\Models\Application;
use App\Models\RedirectUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectUrls extends Controller
{

    public function index(Index $request)
    {
        $redirect_urls = RedirectUrl::whereHas('application', function ($query) {
            return $query->mine();
        });
        if ($request->has('application_id') && $request->application) {
            $redirect_urls = $redirect_urls->where('application_id', $request->application_id);
        }
        return ResourcesRedirectUrl::collection($redirect_urls->paginate($request->input("pageSize", 15)));
    }
    public function create(Create $request)
    {
        $application = Application::where('user_id', Auth::user()->id)->where('id', $request->application_id)->first();
        if (!$application) {
            return abort(404, "application not found");
        }
        $redirect_url = RedirectUrl::create($request->only(['application_id', 'url']));
        return ResourcesRedirectUrl::make($redirect_url);
    }
    public function edit(Edit $request, RedirectUrl $redirect_url)
    {
        $redirect_url->fill($request->only(['url', 'application_id']))->save();
        return ResourcesRedirectUrl::make($redirect_url);
    }
    public function delete(Request $request, RedirectUrl $redirect_url)
    {
        $redirect_url->delete();
        return 'ok';
    }
}
