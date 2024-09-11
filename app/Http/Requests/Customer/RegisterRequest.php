<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="RegisterRequest",
 *     title="RegisterRequest",
 *     description="Request body for Register Request",
 *     required={"username", "email", "password", "password_confirmation"},
 *     @OA\Property(
 *         property="username",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="email",
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
class RegisterRequest extends FormRequest
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
            'username' => 'required|unique:customers,username',
            'email' => 'required|unique:customers,email',
            'password' => 'required|confirmed',
        ];
    }
}
