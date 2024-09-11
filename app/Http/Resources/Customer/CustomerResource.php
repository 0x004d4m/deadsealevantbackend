<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CustomerResource",
 *     title="Customer Resource",
 *     description="Resource of the Customer object",
 *     @OA\Property(
 *         property="id",
 *         type="int"
 *     ),
 *     @OA\Property(
 *         property="username",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="boolean"
 *     ),
 *     @OA\Property(
 *         property="first_name",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="access_token",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="email_token",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="email_verified",
 *         type="boolean"
 *     ),
 * )
 */
class CustomerResource extends JsonResource
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
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'access_token' => $this->access_token,
            'email_token' => $this->email_token,
            'email_verified' => $this->email_verified,
        ];
    }
}
