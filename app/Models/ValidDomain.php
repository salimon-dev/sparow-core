<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Traits\Paginate;
use App\Traits\Uuids;

class ValidDomain extends Model
{
    use HasFactory, Uuids, Paginate;
    public function application()
    {
        return $this->belongsTo(Application::class, "application_id");
    }
}
