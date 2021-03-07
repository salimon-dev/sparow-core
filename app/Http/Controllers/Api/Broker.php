<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Broker\VerifyAccess;
use App\Http\Resources\Profile as ResourcesProfile;
use Auth;

class Broker extends Controller
{
    public function verifyToken()
    {
        return ResourcesProfile::make(Auth::user());
    }
    // channels are in format subject:entity_id:attr0:attr1...
    public function verifyAccess(VerifyAccess $request)
    {
        $parts = explode(':', $request->channel);
        if (sizeof($parts) < 2) {
            abort(403);
        }
        $subject = $parts[0];
        $entity_id = $parts[1];
        switch ($subject) {
            case 'profile':
                if ($entity_id == Auth::user()->id) {
                    return 'ok';
                } else {
                    abort(403);
                }
                break;
        }
        abort(403);
    }
}
