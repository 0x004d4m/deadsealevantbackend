<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ResetPasswordRequest",
 *     title="Reset Password Request",
 *     description="Request body for Reset Password Request",
 *     required={"token", "password", "password_confirmation"},
 *     @OA\Property(
 *         property="token",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="password_confirmation",
 *         type="string"
 *     ),
 * )
 */
class ResetPasswordRequest extends FormRequest
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
            'token' => 'required|exists:customers,forget_token',
            'password' => 'required|confirmed',
        ];
    }
}
