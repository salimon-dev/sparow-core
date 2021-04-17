<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Permission as ResourcesPermission;
use App\Models\Permission;

class Permissions extends Controller
{
    public function mine()
    {
        return ResourcesPermission::collection(Permission::mine()->paginate($request->input("pageSize", 15)));
    }
}
