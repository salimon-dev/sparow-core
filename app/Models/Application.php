<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Application extends Model
{
    use HasFactory, Uuids;
    protected $fillable = ['title', 'description', 'secret_token', 'public_token', 'user_id'];

    public function scopeMine($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }
}
