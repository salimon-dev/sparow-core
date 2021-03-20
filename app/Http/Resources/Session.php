<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'id' => $this->id,
            'application' => $this->application,
            'agent' => $this->agent,
            'name' => $this->name,
            'scopes' => $this->scopes,
        ];
        return parent::toArray($request);
    }
}
