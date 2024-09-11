<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ForgetResource",
 *     title="Forget Resource",
 *     description="Resource of the Forget object",
 *     @OA\Property(
 *         property="forget_token",
 *         type="string"
 *     ),
 * )
 */
class ForgetResource extends JsonResource
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
            'forget_token' => $this->forget_token,
        ];
    }
}
