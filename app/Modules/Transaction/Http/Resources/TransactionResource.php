<?php

namespace App\Modules\Transaction\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'description' => $this->resource->description,
            'total' => $this->resource->total,
            'source' => $this->resource->source,
            'category' => $this->resource->category,
            'category_id' => $this->resource->category_id,
            'date' => $this->resource->date,
            'created_at' => $this->resource->created_at,
        ];
    }
}
