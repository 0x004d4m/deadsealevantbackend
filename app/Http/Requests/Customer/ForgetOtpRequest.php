<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ForgetOtpRequest",
 *     title="Forget Otp Request",
 *     description="Request body for Forget Otp Request",
 *     required={"token", "code"},
 *     @OA\Property(
 *         property="token",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="code",
 *         type="string"
 *     ),
 * )
 */
class ForgetOtpRequest extends FormRequest
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
            'token' => 'required|filled|exists:customers,forget_token',
            'code' => 'required|filled|exists:customers,forget_code',
        ];
    }
}
