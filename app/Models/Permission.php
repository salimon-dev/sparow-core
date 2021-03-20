<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $primary = 'id';
    protected $table = 'permissions';
    protected $fillable = ['user_id', 'scope'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
