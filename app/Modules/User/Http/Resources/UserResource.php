<?php

namespace App\Modules\User\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->getAttribute('name'),
            'email' => $this->resource->getAttribute('email'),
            'phone' => $this->resource->getAttribute('phone'),
            'website' => $this->resource->getAttribute('website'),
            'rating' => $this->resource->getAttribute('rating'),
            'description' => $this->resource->getAttribute('description'),
            'address' => $this->resource->getAttribute('address'),
            'image' => $this->resource->getAttribute('image'),
            'latitude' => $this->resource->getAttribute('latitude'),
            'longitude' => $this->resource->getAttribute('longitude'),
            'other_details' => $this->resource->getAttribute('other_details'),
            'created_at' => $this->resource->getAttribute('created_at'),
        ];
    }
}
