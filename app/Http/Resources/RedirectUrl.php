<?php

namespace App\Http\Resources;

use App\Models\RedirectUrl as ModelsRedirectUrl;
use Illuminate\Http\Resources\Json\JsonResource;

class RedirectUrl extends JsonResource
{
    public $collects = ModelsRedirectUrl::class;
    public $preserveKeys = true;
    public static $wrap = 'redirect_url';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'application' => Application::make($this->application),
            'url' => $this->url,
        ];
    }
}
