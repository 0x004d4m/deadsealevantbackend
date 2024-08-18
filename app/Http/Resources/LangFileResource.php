<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *   schema="LangFileResource",
 *   title="Lang File Resource",
 *   description="Resource of the Lang File object",
 *   @OA\Property(
 *     property="lang_file_name",
 *     type="object",
 *     additionalProperties={
 *       @OA\Property(
 *         property="key",
 *         type="string",
 *         example="value"
 *       ),
 *       @OA\Property(
 *         property="key2",
 *         type="string",
 *         example="value2"
 *       )
 *     }
 *   ),
 * )
 */
class LangFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
