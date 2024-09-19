<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="SettingResource",
 *     title="SettingResource",
 *     description="Resource of the Settings object",
 *     @OA\Property(
 *         property="tax",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="shipping",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="shipping_free_after",
 *         type="string"
 *     ),
 * )
 */
class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'tax' => $this->tax . '%',
            'shipping' => $this->shipping . '$',
            'shipping_free_after' => $this->shipping_free_after . '$',
        ];
    }
}
