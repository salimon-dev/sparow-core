<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class RedirectUrl extends Model
{
    use HasFactory, Uuids;
    protected $table = 'redirect_urls';
    protected $fillable = ["application_id", "url"];

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}
