<?php

namespace App\Http\Resources\Guest;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="GuestRegisterResource",
 *     title="Guest Register Resource",
 *     description="Resource of the Guest Register object",
 *     @OA\Property(
 *         property="guest_token",
 *         type="string"
 *     ),
 * )
 */
class RegisterResource extends JsonResource
{
    public function withResponse($request, $response)
    {
        if ($request->isMethod('post')) {
            $response->setStatusCode(201);
        }
        $response->setStatusCode(200);
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'guest_token' => $this->access_token
        ];
    }
}
