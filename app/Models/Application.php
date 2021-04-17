<?php

namespace App\Models;

use App\Traits\Paginate;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Application extends Model
{
    use HasFactory, Uuids, Paginate;
    protected $table = 'applications';
    protected $fillable = ['title', 'description', 'secret_token', 'public_token', 'user_id'];
    /**
     * returns applications belongs to authorized user
     */
    public function scopeMine($query)
    {
        return $query->where('user_id', Auth::user()->id);
    }
    /**
     * returns user object that created this application
     */
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
    /**
     * generates a random string
     */
    private function randomString(int $length): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < $length; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randstring;
    }
    public function regenerateTokens()
    {
        $this->secret_token = $this->randomString(128);
        $this->public_token = $this->randomString(256);
    }
}
