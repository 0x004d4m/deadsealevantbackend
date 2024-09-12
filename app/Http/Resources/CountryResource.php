<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CountryResource",
 *     title="Country Resource",
 *     description="Resource of the Country object",
 *     @OA\Property(
 *         property="id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string"
 *     ),
 * )
 */
class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
