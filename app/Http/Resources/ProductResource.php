<?php

namespace App\Http\Resources;

use App\Models\Cart;
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
 *         property="quantity_in_cart",
 *         type="int"
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
    private function removeChars($text){
        return str_replace('\r', '', str_replace('\n', '', $text));
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $quantity_in_cart = 1;
        if($request->customer_id){
            $Cart = Cart::where('product_id', $this->id)->where('customer_id', $request->customer_id)->whereNull('order_id')->first();
            if($Cart){
                $quantity_in_cart = $Cart->quantity;
            }
        }
        if($request->guest_id){
            $Cart = Cart::where('product_id', $this->id)->where('guest_id', $request->guest_id)->whereNull('order_id')->first();
            if($Cart){
                $quantity_in_cart = $Cart->quantity;
            }
        }
        $description = $this->description;
        if (!isset($request->id)) {
            $description = substr($this->description, 0, 100).'...';
        }
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'category' => new CategoryResource($this->category),
            'title' => $this->removeChars($this->title),
            'description' => $this->removeChars($description),
            'image' => $this->image,
            'price' => $this->price .' $',
            'stock' => $this->stock,
            'quantity_in_cart' => $quantity_in_cart,
            'shipping_terms' => $this->removeChars(__('terms_and_conditions.shipping')),
            'product_reviews' => ProductReviewsResource::collection($this->productReviews),
            'product_images' => ProductImagesResource::collection($this->productImages),
        ];
    }
}
