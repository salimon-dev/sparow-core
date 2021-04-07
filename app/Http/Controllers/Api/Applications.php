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
        $applications = Application::mine();
        if ($request->exists('id') && $request->id) {
            $applications = $applications->where('id', $request->id);
        }
        if ($request->exists("title") && $request->title) {
            $applications = $applications->where("title", "%" . $request->title . "%");
        }
        return ResourcesApplication::collection($applications->paginate());
    }

    public function create(Create $request)
    {
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
        $application->fill($request->only(['title', 'description']));
        $application->save();
        return ResourcesApplication::make($application);
    }

    public function delete(Request $request, Application $application)
    {
        $application->delete();
        return 'ok';
    }

    public function refreshToken(Request $request, Application $application)
    {
        $application->regenerateTokens();
        $application->save();
        return ResourcesApplication::make($application);
    }
}
