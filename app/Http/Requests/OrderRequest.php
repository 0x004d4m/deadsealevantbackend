<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="OrderRequest",
 *     title="Order Request",
 *     description="Request body for placing an order. If `customer access token` is provided, `customer_address_id` is required. Otherwise, the rest of the fields are required.",
 *     @OA\Property(
 *         property="customer_address_id",
 *         type="integer",
 *         description="Address ID of the customer, required if `customer access token` is provided.",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         description="First name of the guest. Required if `customer access token` is not provided.",
 *         example="John"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         description="Last name of the guest. Required if `customer access token` is not provided.",
 *         example="Doe"
 *     ),
 *     @OA\Property(
 *         property="country_id",
 *         type="integer",
 *         description="ID of the country. Required if access token` is not provided.",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="phone_number",
 *         type="string",
 *         description="Phone number of the guest. Required if `customer access token` is not provided.",
 *         example="+1234567890"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         description="Primary address of the guest. Required if `customer access token` is not provided.",
 *         example="123 Main St."
 *     ),
 *     @OA\Property(
 *         property="address_details",
 *         type="string",
 *         description="Additional details for the address of the guest. Required if `customer access token` is not provided.",
 *         example="Apartment 4B"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         description="City of the guest. Required if `customer access token` is not provided.",
 *         example="New York"
 *     ),
 *     @OA\Property(
 *         property="state",
 *         type="string",
 *         description="State or province of the guest. Required if `customer access token` is not provided.",
 *         example="NY"
 *     ),
 *     @OA\Property(
 *         property="zip_code",
 *         type="string",
 *         description="ZIP code of the guest. Required if `customer access token` is not provided.",
 *         example="10001"
 *     )
 * )
 */
class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_address_id' => ['required_if:customer_id,exists:customers,id'],
            'first_name' => ['required_without:customer_id'],
            'last_name' => ['required_without:customer_id'],
            'country_id' => ['required_without:customer_id', 'exists:countries,id'],
            'phone_number' => ['required_without:customer_id'],
            'address' => ['required_without:customer_id'],
            'address_details' => ['required_without:customer_id'],
            'city' => ['required_without:customer_id'],
            'state' => ['required_without:customer_id'],
            'zip_code' => ['required_without:customer_id'],
        ];
    }
}
