<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Applications\Create;
use App\Http\Requests\Api\Applications\Edit;
use App\Http\Requests\Api\Applications\Index;
use App\Http\Requests\Api\UpdateProfile;
use App\Http\Resources\Application as ResourcesApplication;
use App\Http\Resources\Profile as ResourcesProfile;
use App\Jobs\ProfileUpdated;
use App\Models\Application;
use App\Models\Passport\Token;
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
        return ResourcesApplication::collection($applications->paginate());
    }

    function randomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < $length; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randstring;
    }

    public function create(Create $request)
    {
        $application = new Application;
        $application->fill($request->only(['title', 'description']));
        $application->fill([
            'secret_token' => $this->randomString(128),
            'public_token' => $this->randomString(256),
            'user_id' => Auth::user()->id
        ]);
        $application->save();
        return ResourcesApplication::make($application);
    }

    public function edit(Edit $request, Application $application)
    {
        $application->fill($request->only(['title', 'description']));
        $application->save();
        return ResourcesApplication::make($application);
    }
}
