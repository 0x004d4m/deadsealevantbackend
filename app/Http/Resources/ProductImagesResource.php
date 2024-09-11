<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProductImagesResource",
 *     title="Product Images Resource",
 *     description="Resource of the Product Images object",
 *     @OA\Property(
 *         property="id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="product_id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         type="string"
 *     ),
 * )
 */
class ProductImagesResource extends JsonResource
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
            'image' => strpos($this->image, 'http') === 0? $this->image : url('storage/' . $this->image),
            'product_id' => $this->product_id,
        ];
    }
}
