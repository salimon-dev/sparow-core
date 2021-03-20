<?php

namespace App\Http\Resources;

use App\Models\Application as ModelsApplication;
use Illuminate\Http\Resources\Json\JsonResource;

class Application extends JsonResource
{
    public $collects = ModelsApplication::class;
    public $preserveKeys = true;
    public static $wrap = 'application';
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'tokens' => [
                'public' => $this->public_token,
                'secret' => $this->secret_token,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
