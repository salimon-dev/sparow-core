<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ValidDomains\Create;
use App\Http\Requests\Api\ValidDomains\Edit;
use App\Http\Requests\Api\ValidDomains\Index;
use App\Http\Resources\ValidDomain as ResourcesValidDomain;
use App\Models\Application;
use App\Models\ValidDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidDomains extends Controller
{

    public function index(Index $request)
    {
        $redirect_urls = ValidDomain::whereHas('application', function ($query) {
            return $query->mine();
        });
        if ($request->has('application_id') && $request->application) {
            $redirect_urls = $redirect_urls->where('application_id', $request->application_id);
        }
        return ResourcesValidDomain::collection($redirect_urls->paginate($request->input("pageSize", 15)));
    }
    public function create(Create $request)
    {
        $application = Application::where('user_id', Auth::user()->id)->where('id', $request->application_id)->first();
        if (!$application) {
            return abort(404, "application not found");
        }
        $redirect_url = ValidDomain::create($request->only(['application_id', 'url']));
        return ResourcesValidDomain::make($redirect_url);
    }
    public function edit(Edit $request, ValidDomain $redirect_url)
    {
        $redirect_url->fill($request->only(['url', 'application_id']))->save();
        return ResourcesValidDomain::make($redirect_url);
    }
    public function delete(Request $request, ValidDomain $redirect_url)
    {
        $redirect_url->delete();
        return 'ok';
    }
}
