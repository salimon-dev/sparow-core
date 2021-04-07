<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class Session extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $current_token = Auth::user()->token();
        return [
            'id' => $this->id,
            'application' => Application::make($this->application),
            'agent' => $this->agent,
            'name' => $this->name,
            'scopes' => $this->scopes,
            'current' => $current_token->id == $this->id
        ];
        return parent::toArray($request);
    }
}
