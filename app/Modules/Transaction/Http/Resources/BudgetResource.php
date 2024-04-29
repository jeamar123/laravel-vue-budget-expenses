<?php

namespace App\Modules\Transaction\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BudgetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->resource->name,
            'budget' => $this->resource->budget ?? 0,
            'spent' => $this->resource->spent ?? 0,
            'remaining' => $this->resource->remaining ?? 0,
        ];
    }
}
