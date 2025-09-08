<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProfessorCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => ProfessorResource::collection($this->collection),
        ];
    }
    public function with(Request $request): array
    {
        return [
            'status'  => 'success',
            'message' => 'Professors retrieved successfully',
            'meta'    => [
                'current_page' => method_exists($this->resource, 'currentPage') ? $this->resource->currentPage() : null,
                'per_page'     => method_exists($this->resource, 'perPage') ? $this->resource->perPage() : null,
                'total'        => method_exists($this->resource, 'total') ? $this->resource->total() : ($this->collection->count() ?? null),
                'last_page'    => method_exists($this->resource, 'lastPage') ? $this->resource->lastPage() : null,
            ],
        ];
    }
}
