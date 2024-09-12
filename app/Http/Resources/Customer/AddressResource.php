<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\CountryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="AddressResource",
 *     title="Address Resource",
 *     description="Resource of the Address object",
 *     @OA\Property(
 *         property="id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="customer_id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="country_id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="country",
 *         ref="#/components/schemas/CountryResource"
 *     ),
 *     @OA\Property(
 *         property="phone_number",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="address_details",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="state",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="zip_code",
 *         type="string"
 *     ),
 * )
 */
class AddressResource extends JsonResource
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
            'country_id' => $this->country_id,
            'country' => new CountryResource($this->country),
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'address_details' => $this->address_details,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
        ];
    }
}
