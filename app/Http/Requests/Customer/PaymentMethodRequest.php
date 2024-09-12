<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="PaymentMethodRequest",
 *     title="Payment Method Request",
 *     description="Request body for Payment Method Request",
 *     required={"card_number", "expiry_month", "expiry_year", "cvv", "cardholder_name"},
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
class PaymentMethodRequest extends FormRequest
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
            'card_number' => 'required|filled',
            'expiry_month' => 'required|filled',
            'expiry_year' => 'required|filled',
            'cvv' => 'required|filled',
            'cardholder_name' => 'required|filled',
        ];
    }
}
