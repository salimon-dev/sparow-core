<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Profile extends JsonResource
{
    public $collects = User::class;
    public $preserveKeys = true;
    public static $wrap = 'user';
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'username' => $this->username,
            'email' => [
                'address' => $this->email,
                'verified' => $this->email_verified_at != 0,
                'verified_at' => $this->when($this->email_verified_at != 0, 'email_verified_at'),
            ],
            'phone' => [
                'number' => $this->phone,
                'verified' => $this->phone_verified_at != 0,
                'verified_at' => $this->when($this->phone_verified_at != 0, 'phone_verified_at'),
            ],
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'avatar' => $this->getAvatarPublicUrl(),
            'uploaded_avatar' => $this->hasAvatar(),
            'status' => $this->status,
        ];
        foreach ($this->data as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }

    public function __construct($resource, $data = [])
    {
        parent::__construct($resource);
        $this->resource = $resource;

        $this->data = $data;
    }
}
