<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="LanguageResource",
     *     title="Language Resource",
     *     description="Resource of the Language object",
     *     @OA\Property(
     *         property="id",
     *         type="int"
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="native",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="abbr",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="default",
     *         type="boolean"
     *     ),
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'native' => $this->native,
            'name' => $this->name,
            'abbr' => $this->abbr,
            'default' => $this->default,
        ];
    }
}
