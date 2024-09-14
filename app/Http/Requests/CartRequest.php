<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="CartRequest",
 *     title="Cart Request",
 *     description="Request body for Cart Request",
 *     required={"quantity", "product_id"},
 *     @OA\Property(
 *         property="quantity",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="product_id",
 *         type="int"
 *     ),
 * )
 */
class CartRequest extends FormRequest
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
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|exists:products,id',
        ];
    }
}
