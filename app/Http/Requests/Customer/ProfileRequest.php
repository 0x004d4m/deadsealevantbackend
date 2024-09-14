<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ProfileRequest",
 *     title="Profile Request",
 *     description="Request body for Profile Request",
 *     required={"first_name", "last_name"},
 *     @OA\Property(
 *         property="first_name",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string"
 *     ),
 * )
 */
class ProfileRequest extends FormRequest
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
            'first_name' => 'required|filled',
            'last_name' => 'required|filled',
        ];
    }
}
