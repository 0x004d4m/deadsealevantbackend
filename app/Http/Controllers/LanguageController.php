<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageRequest;
use App\Http\Resources\LanguageResource;
use Backpack\LangFileManager\app\Models\Language;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="Language",
 *     description="API Endpoints of Language"
 * )
 */
class LanguageController extends Controller
{
    /**
     * @OA\Get(
     *  path="/api/languages",
     *  summary="List Languages",
     *  description="List Languages",
     *  operationId="ListLanguages",
     *  tags={"Language"},
     *  @OA\Response(
     *    response=200,
     *    description="Returns a list of Languages",
     *    @OA\JsonContent(
     *      @OA\Property(
     *        property="data",
     *        type="array",
     *        @OA\Items(ref="#/components/schemas/LanguageResource")
     *      )
     *    )
     *  ),
     *  @OA\Response(
     *    response=500,
     *    description="Server Error",
     *    @OA\JsonContent(
     *      @OA\Property(property="error")
     *    )
     *  )
     * )
     */
    public function index(Request $request) {
        return LanguageResource::collection(
            Language::where('active', 1)->get()
        );
    }
}
