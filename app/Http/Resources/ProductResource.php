<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ProductResource",
 *     title="Product Resource",
 *     description="Resource of the Product object",
 *     @OA\Property(
 *         property="id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="category",
 *         ref="#/components/schemas/CategoryResource"
 *     ),
 *     @OA\Property(
 *         property="category_id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="double"
 *     ),
 *     @OA\Property(
 *         property="stock",
 *         type="double"
 *     ),
 *     @OA\Property(
 *         property="shipping_terms",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="product_reviews",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProductReviewsResource")
 *     ),
 *     @OA\Property(
 *         property="product_images",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProductImagesResource")
 *     ),
 * )
 */
class ProductResource extends JsonResource
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
            'category_id' => $this->category_id,
            'category' => new CategoryResource($this->category),
            'title' => $this->title,
            'description' => $this->description,
            'image' => url('storage/' . $this->image),
            'price' => $this->price,
            'stock' => $this->stock,
            'shipping_terms' => $this->shipping_terms,
            'product_reviews' => ProductReviewsResource::collection($this->productReviews),
            'product_images' => ProductImagesResource::collection($this->productImages),
        ];
    }
}
