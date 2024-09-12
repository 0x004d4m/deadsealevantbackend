<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Schema(
 *     schema="LoginRequest",
 *     title="Login Request",
 *     description="Request body for Login Request",
 *     required={"user", "password"},
 *     @OA\Property(
 *         property="user",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string"
 *     ),
 * )
 */
class LoginRequest extends FormRequest
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
            'user' => [
                'required',
                'filled',
                function ($attribute, $value, $fail) {
                    if (!DB::table('customers')->where('email', $value)->orWhere('username', $value)->exists()) {
                        $fail('The selected email or username is invalid.');
                    }
                },],
            'password' => 'required|filled',
        ];
    }
}
