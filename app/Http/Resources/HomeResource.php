<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *   schema="HomeResource",
 *   title="Home Resource",
 *   description="Resource of the Home object",
 *   @OA\Property(
 *     property="translations",
 *     type="array",
 *     @OA\Items(ref="#/components/schemas/LangFileResource")
 *   ),
 *   @OA\Property(
 *     property="images",
 *     type="array",
 *     @OA\Items(ref="#/components/schemas/ImageResource")
 *   ),
 *   @OA\Property(
 *     property="categories",
 *     type="array",
 *     @OA\Items(ref="#/components/schemas/CategoryResource")
 *   ),
 *   @OA\Property(
 *     property="availability",
 *     type="array",
 *     @OA\Items(ref="#/components/schemas/AvailabilityResource")
 *   ),
 *   @OA\Property(
 *     property="setting",
 *     ref="#/components/schemas/SettingResource"
 *   ),
 * )
 */
class HomeResource extends JsonResource
{
    public function __construct($languageFiles, $images, $categories, $availability, $setting)
    {
        parent::__construct([
            'translations' => $languageFiles,
            'images' => $images,
            'categories' => $categories,
            'availability' => $availability,
            'setting' => $setting,
        ]);
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'translations' => $this->resource['translations'],
            'images' => ImageResource::collection($this->resource['images']),
            'categories' => CategoryResource::collection($this->resource['categories']),
            'availability' => AvailabilityResource::collection($this->resource['availability']),
            'setting' => new SettingResource($this->resource['setting']),
        ];
    }
}
