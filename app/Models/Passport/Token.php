<?php

namespace App\Models\Passport;

use App\Models\Application;
use Laravel\Passport\Token as TokenModel;

class Token extends TokenModel
{
    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}
