<?php

namespace Marshmallow\Reviews\Kiyoh\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KiyohInviteResource extends JsonResource
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
            'success' => true,
            'kiyoh_response' => $this->resource->json()
        ];
        return parent::toArray($request);
    }
}
