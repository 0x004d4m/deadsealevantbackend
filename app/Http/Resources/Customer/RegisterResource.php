<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="RegisterResource",
 *     title="Register Resource",
 *     description="Resource of the Register object",
 *     @OA\Property(
 *         property="email_token",
 *         type="string"
 *     ),
 * )
 */
class RegisterResource extends JsonResource
{
    public function withResponse($request, $response)
    {
        $response->setStatusCode(201);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'email_token' => $this->email_token,
        ];
    }
}
