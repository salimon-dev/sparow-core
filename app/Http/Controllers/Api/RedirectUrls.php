<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Applications\Create;
use App\Http\Requests\Api\Applications\Edit;
use App\Http\Requests\Api\Applications\Index;
use App\Http\Resources\Application as ResourcesApplication;
use App\Models\Application;
use App\Models\RedirectUrl;
use Auth;
use Illuminate\Http\Request;

class RedirectUrls extends Controller
{

    public function index(Index $request)
    {
        $redirect_urls = RedirectUrl::whereHas('application', function ($query) {
            return $query->mine();
        });
        return $redirect_urls->get();
    }
    public function create(Request $request)
    {
    }
}
