<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AddressRequest",
 *     title="Address Request",
 *     description="Request body for Address Request",
 *     required={"country_id", "phone_number", "address", "address_details", "city", "state", "zip_code"},
 *     @OA\Property(
 *         property="country_id",
 *         type="int"
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
class AddressRequest extends FormRequest
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
            'country_id' => 'required|filled|exists:countries,id',
            'phone_number' => 'required|filled',
            'address' => 'required|filled',
            'address_details' => 'required|filled',
            'city' => 'required|filled',
            'state' => 'required|filled',
            'zip_code' => 'required|filled|digits:5',
        ];
    }
}
