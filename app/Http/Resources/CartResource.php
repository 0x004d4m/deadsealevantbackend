<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CartResource",
 *     title="Cart Resource",
 *     description="Resource of the Cart object",
 *     @OA\Property(
 *         property="id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="quantity",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="product_id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="product",
 *         ref="#/components/schemas/ProductResource"
 *     ),
 *     @OA\Property(
 *         property="customer_id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="guest_id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="has_product_review",
 *         type="boolean"
 *     ),
 * )
 */
class CartResource extends JsonResource
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
            'quantity' => $this->quantity,
            'product_id' => $this->product_id,
            'product' => new ProductResource($this->product),
            'customer_id' => $this->customer_id,
            'guest_id' => $this->guest_id,
            'has_product_review' => $this->productReview ? true : false,
        ];
    }
}
