<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="AvailabilityResource",
 *     title="Availability Resource",
 *     description="Resource of the Availability object",
 *     @OA\Property(property="id", type="string"),
 *     @OA\Property(property="name", type="string"),
 * )
 */
class AvailabilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
        ];
    }
}
