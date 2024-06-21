<?php

namespace App\Modules\Transaction\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'name' => $this->resource->name,
            'budget' => $this->resource->budget ?? 0,
            'actual' => $this->resource->actual ?? 0,
            'type' => $this->resource->type,
        ];
    }
}
