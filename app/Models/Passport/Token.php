<?php

namespace App\Models\Passport;

use App\Models\Application;
use App\Traits\Paginate;
use Laravel\Passport\Token as TokenModel;

class Token extends TokenModel
{
    use Paginate;
    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}
