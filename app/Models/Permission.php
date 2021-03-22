<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Permission extends Model
{
    use HasFactory, Uuids;
    protected $primary = 'id';
    protected $table = 'permissions';
    protected $fillable = ['user_id', 'scope'];
    /**
     * return relation to user of permission
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * returns permissions of authenticated user
     */
    public function scopeMine($query)
    {
        return $query->where("user_id", Auth::user()->id);
    }
}
