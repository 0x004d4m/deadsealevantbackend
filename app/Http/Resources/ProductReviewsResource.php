<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProductReviewsResource",
 *     title="ProductReviewsResource",
 *     description="Resource of the Product Reviews object",
 *     @OA\Property(
 *         property="id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="stars",
 *         type="integer"
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="product_id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="customer_id",
 *         type="int"
 *     ),
 * )
 */
class ProductReviewsResource extends JsonResource
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
            'name' => $this->customer->username,
            'stars' => $this->stars,
            'message' => $this->message,
            'product_id' => $this->product_id,
            'customer_id' => $this->customer_id,
        ];
    }
}
