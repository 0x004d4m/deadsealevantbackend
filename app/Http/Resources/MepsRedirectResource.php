<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="MepsRedirectResource",
 *     title="Meps Redirect Resource",
 *     description="Resource of the Meps Redirect object",
 *     @OA\Property(property="redirect_url", type="string"),
 * )
 */
class MepsRedirectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'redirect_url' => $this->redirect_url
        ];
    }
}
