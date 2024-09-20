<?php

namespace App\Http\Resources;

use App\Http\Resources\Customer\AddressResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="OrderResource",
 *     title="Order Resource",
 *     description="Resource of the Order object",
 *     @OA\Property(
 *         property="id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="guest_id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="customer_id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="customer_address_id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="customer_address",
 *         ref="#/components/schemas/AddressResource"
 *     ),
 *     @OA\Property(
 *         property="response_message",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="order_status_id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="order_status",
 *         ref="#/components/schemas/CategoryResource"
 *     ),
 *     @OA\Property(
 *         property="subtotal",
 *         type="double"
 *     ),
 *     @OA\Property(
 *         property="tax",
 *         type="double"
 *     ),
 *     @OA\Property(
 *         property="shipping",
 *         type="double"
 *     ),
 *     @OA\Property(
 *         property="total",
 *         type="double"
 *     ),
 *     @OA\Property(
 *         property="cart_items",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/CartResource")
 *     ),
 * )
 */
class OrderResource extends JsonResource
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
            'guest_id' => $this->guest_id,
            'customer_id' => $this->customer_id,
            'customer_address_id' => $this->customer_address_id,
            'customer_address' => new AddressResource($this->customerAddress),
            'response_message' => $this->response_message,
            'order_status_id' => $this->order_status_id,
            'order_status' => new OrderStatusResource($this->orderStatus),
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'shipping' => $this->shipping,
            'total' => $this->total,
            'cart_items' => CartResource::collection($this->carts),
        ];
    }
}
