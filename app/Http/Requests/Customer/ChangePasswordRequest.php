<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ChangePasswordRequest",
 *     title="Change Password Request",
 *     description="Request body for Change Password Request",
 *     required={"current_password", "new_password", "new_password_confirmation"},
 *     @OA\Property(
 *         property="current_password",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="new_password",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="new_password_confirmation",
 *         type="string"
 *     ),
 * )
 */
class ChangePasswordRequest extends FormRequest
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
            'current_password' => 'required|filled',
            'new_password' => 'required|filled|confirmed',
        ];
    }
}
