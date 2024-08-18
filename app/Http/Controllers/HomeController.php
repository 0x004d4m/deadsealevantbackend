<?php

namespace App\Http\Controllers;

use App\Http\Resources\HomeResource;
use App\Models\Category;
use App\Models\Image;
use Backpack\LangFileManager\app\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/**
 * @OA\Tag(
 *     name="Home",
 *     description="API Endpoints of Home"
 * )
 */
class HomeController extends Controller
{
    /**
     * @OA\Get(
     *  path="/api/home",
     *  summary="Returns Home data",
     *  description="Returns Home data",
     *  operationId="Home",
     *  tags={"Home"},
     *  @OA\Response(
     *    response=200,
     *    description="Returns Home data",
     *    @OA\JsonContent(
     *      @OA\Property(
     *        property="data",
     *        type="array",
     *        @OA\Items(ref="#/components/schemas/HomeResource")
     *      )
     *    )
     *  ),
     *  @OA\Response(
     *    response=500,
     *    description="Server Error",
     *    @OA\JsonContent(
     *      @OA\Property(property="error")
     *    )
     *  ),
     *  @OA\Response(
     *    response=422,
     *    description="Wrong input response",
     *    @OA\JsonContent(
     *      @OA\Property(property="message", type="string", example=""),
     *      @OA\Property(property="errors", type="object",
     *        @OA\Property(property="dynamic-error-keys", type="array",
     *          @OA\Items(type="string")
     *        )
     *      )
     *    )
     *  )
     * )
     */
    public function index(Request $request)
    {
        $langPath = lang_path();
        $files = File::allFiles($langPath);
        $languageFiles = [];
        foreach ($files as $file) {
            $path = $file->getPathname();
            if (strpos($path, 'vendor') === false && strpos($path, $request->locale) !== false) {
                $fileName = pathinfo($path, PATHINFO_FILENAME);
                $arrayContent = include $path;
                $languageFiles[$fileName] = $arrayContent;
            }
        }
        $images = Image::all();
        $categories = Category::all();
        return new HomeResource($languageFiles, $images, $categories);
    }
}
