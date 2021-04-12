<?php

namespace App\Models;

use App\Passport\CustomizedCreateToken;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Uuids, HasApiTokens, CustomizedCreateToken;

    protected $fillable = [
        'username', 'email', 'phone', 'first_name', 'last_name', 'avatar', 'phone_verified_at', 'email_verified_at', 'last_login', 'status'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'last_login' => 'datetime',
    ];
    /**
     * returns the public url on avatar
     */
    public function getAvatarPublicUrl(): string
    {
        if ($this->avatar)
            return (env('AWS_PATH') . '/' . $this->avatar);
        else return url("sample-avatar.svg");
    }
    public function hasAvatar(): bool
    {
        return $this->avatar != null;
    }
    /**
     * updates avatar from given file
     */
    public function updateAvatar($file): bool
    {
        $current = $this->avatar;
        $this->avatar = Storage::cloud()->put('/avatars', $file);
        $this->save();
        Storage::cloud()->delete($current);
        return true;
    }
    /**
     * updates avatar from a url
     */
    public function updateAvatarFromUrl(string $url): bool
    {
        $contents = file_get_contents($url);
        return $this->updateAvatar($contents);
    }
    /**
     * relation to user permissions
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class, 'user_id');
    }
    /**
     * relation to user applications
     */
    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id');
    }
    /**
     * checks if this user has permission to an scope or not
     * @param permission
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->whereScope($permission)->count() > 0;
    }
}
