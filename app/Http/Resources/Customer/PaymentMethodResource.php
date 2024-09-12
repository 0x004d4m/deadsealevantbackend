<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PaymentMethodResource",
 *     title="Payment Method Resource",
 *     description="Resource of the Payment Method object",
 *     @OA\Property(
 *         property="id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="customer_id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="card_number",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="expiry_month",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="expiry_year",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="cvv",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="cardholder_name",
 *         type="string"
 *     ),
 * )
 */
class PaymentMethodResource extends JsonResource
{
    public function withResponse($request, $response)
    {
        if ($request->isMethod('post')) {
            $response->setStatusCode(201);
        }
        $response->setStatusCode(200);
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'card_number' => $this->card_number,
            'expiry_month' => $this->expiry_month,
            'expiry_year' => $this->expiry_year,
            'cvv' => $this->cvv,
            'cardholder_name' => $this->cardholder_name,
        ];
    }
}
