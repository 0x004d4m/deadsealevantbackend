<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ForgetOtpResource",
 *     title="Forget Otp Resource",
 *     description="Resource of the Forget Otp object",
 *     @OA\Property(
 *         property="email_token",
 *         type="string"
 *     ),
 * )
 */
class ForgetOtpResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'token' => $this->forget_token
        ];
    }
}
