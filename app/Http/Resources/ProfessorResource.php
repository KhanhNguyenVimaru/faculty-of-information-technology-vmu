<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfessorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'position' => $this->position,
            'birthdate' => $this->birthdate,
            'education_level' => $this->education_level,
            'user' => $this->whenLoaded('user', fn () => [
                'id' => $this->user->id,
                'email' => $this->user->email,
                'name' => $this->user->name,
                'created_at' => $this->user->created_at?->toDateTimeString(),
                'updated_at' => $this->user->updated_at?->toDateTimeString(),
            ]),
            'department' => $this->whenLoaded('department', fn () => [
                'id' => $this->department->id,
                'name' => $this->department->name,
            ]),
        ];
    }
}
