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
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'email' => $this->resource->email,
            'username' => $this->resource->username,
            'role' => $this->resource->role,
            'status' => $this->resource->status,
            'image' => $this->resource->image,
            'currency_code' => $this->resource->currency_code,
            'created_at' => $this->resource->created_at,
        ];
    }
}
