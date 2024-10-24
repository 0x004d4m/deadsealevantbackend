<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ReviewRequest",
 *     title="Review Request",
 *     description="Request body for Review Request",
 *     required={"stars", "message"},
 *     @OA\Property(
 *         property="stars",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string"
 *     ),
 * )
 */
class ReviewRequest extends FormRequest
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
            'stars' => 'required',
            'message' => 'required',
        ];
    }
}
