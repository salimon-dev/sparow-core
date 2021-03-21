<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Applications\Create;
use App\Http\Requests\Api\Applications\Edit;
use App\Http\Requests\Api\Applications\Index;
use App\Http\Resources\Application as ResourcesApplication;
use App\Models\Application;
use Auth;
use Illuminate\Http\Request;

class Applications extends Controller
{

    public function index(Index $request)
    {
        if (Auth::user()->hasPermission('applications')) {
            return abort(403, "you don't have permission to manage applications");
        }
        $applications = Application::mine();
        if ($request->exists('id') && $request->id) {
            $applications = $applications->where('id', $request->id);
        }
        return ResourcesApplication::collection($applications->paginate());
    }

    public function create(Create $request)
    {
        if (Auth::user()->hasPermission('applications')) {
            return abort(403, "you don't have permission to manage applications");
        }
        $application = new Application;
        $application->fill($request->only(['title', 'description']) + [
            'user_id' => Auth::user()->id
        ]);
        $application->regenerateTokens();
        $application->save();
        return ResourcesApplication::make($application);
    }

    public function edit(Edit $request, Application $application)
    {
        if (Auth::user()->hasPermission('applications')) {
            return abort(403, "you don't have permission to manage applications");
        }
        $application->fill($request->only(['title', 'description']));
        $application->save();
        return ResourcesApplication::make($application);
    }

    public function delete(Request $request, Application $application)
    {
        if (Auth::user()->hasPermission('applications')) {
            return abort(403, "you don't have permission to manage applications");
        }
        $application->delete();
        return 'ok';
    }

    public function refreshToken(Request $request, Application $application)
    {
        if (Auth::user()->hasPermission('applications')) {
            return abort(403, "you don't have permission to manage applications");
        }
        $application->regenerateTokens();
        $application->save();
        return ResourcesApplication::make($application);
    }
}
