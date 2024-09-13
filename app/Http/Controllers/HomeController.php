<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralException;
use App\Filters\ProductFilters;
use App\Http\Requests\ContactRequestRequest;
use App\Http\Requests\EmailRequest;
use App\Http\Resources\HomeResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\ContactRequest;
use App\Models\Email;
use App\Models\Image;
use App\Models\Product;
use Backpack\LangFileManager\app\Models\Language;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

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
        $availability = [['id' => 'true', 'name' => __('products.in_stock'), ['id' => 'false', 'name' => __('products.out_of_stock')]]];
        return new HomeResource($languageFiles, $images, $categories, $availability);
    }

    /**
     * @OA\Post(
     *  path="/api/contact_requests",
     *  summary="Send A Contact Request",
     *  description="Send A Contact Request",
     *  operationId="ContactRequest",
     *  tags={"Home"},
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/ContactRequestRequest")
     *  ),
     *  @OA\Response(
     *    response=204,
     *    description="success",
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
     *    description="Wrong credentials response",
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
    public function contactRequest(ContactRequestRequest $contactRequestRequest)
    {
        try {
            ContactRequest::create([
                'name' => $contactRequestRequest->name,
                'email' => $contactRequestRequest->email,
                'subject' => $contactRequestRequest->subject,
                'message' => $contactRequestRequest->message,
            ]);
            return response()->json()->setStatusCode(204);
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }

    /**
     * @OA\Get(
     *  path="/api/products",
     *  summary="List Products",
     *  description="List Products",
     *  operationId="ListProducts",
     *  tags={"Home"},
     *  @OA\Parameter(
     *     name="page",
     *     description="page",
     *     required=false,
     *     in="query",
     *     @OA\Schema(
     *         type="integer"
     *     )
     *  ),
     *  @OA\Parameter(
     *     name="search",
     *     description="search",
     *     required=false,
     *     in="query",
     *     @OA\Schema(
     *         type="string"
     *     )
     *  ),
     *  @OA\Parameter(
     *     name="category_id",
     *     description="category id",
     *     required=false,
     *     in="query",
     *     @OA\Schema(
     *         type="integer"
     *     )
     *  ),
     *  @OA\Parameter(
     *     name="availablity",
     *     description="availablity",
     *     required=false,
     *     in="query",
     *     @OA\Schema(
     *         type="boolean"
     *     )
     *  ),
     *  @OA\Parameter(
     *     name="price_from",
     *     description="price from",
     *     required=false,
     *     in="query",
     *     @OA\Schema(
     *         type="integer"
     *     )
     *  ),
     *  @OA\Parameter(
     *     name="price_to",
     *     description="price to",
     *     required=false,
     *     in="query",
     *     @OA\Schema(
     *         type="integer"
     *     )
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="Returns a list of Products",
     *    @OA\JsonContent(
     *      @OA\Property(
     *        property="data",
     *        type="array",
     *        @OA\Items(ref="#/components/schemas/ProductResource")
     *      ),
     *      @OA\Property(
     *        property="links",
     *        type="object",
     *        @OA\Property(property="first", type="string"),
     *        @OA\Property(property="last", type="string"),
     *        @OA\Property(property="prev", type="string"),
     *        @OA\Property(property="next", type="string"),
     *      ),
     *      @OA\Property(
     *        property="meta",
     *        type="object",
     *        @OA\Property(property="current_page", type="integer"),
     *        @OA\Property(property="from", type="integer"),
     *        @OA\Property(property="last_page", type="integer"),
     *        @OA\Property(property="path", type="string"),
     *        @OA\Property(property="per_page", type="integer"),
     *        @OA\Property(property="to", type="integer"),
     *        @OA\Property(property="total", type="integer"),
     *        @OA\Property(
     *          property="links",
     *          type="array",
     *          @OA\Items(
     *            @OA\Property(property="url", type="string"),
     *            @OA\Property(property="label", type="string"),
     *            @OA\Property(property="active", type="boolean"),
     *          )
     *        ),
     *      ),
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
    public function products(Request $request)
    {
        return ProductResource::collection(Product::filter(new ProductFilters($request))->paginate(12));
    }


    /**
     * @OA\Post(
     *  path="/api/emails",
     *  summary="Send An Email (news letter)",
     *  description="Send An Email (news letter)",
     *  operationId="Email",
     *  tags={"Home"},
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/EmailRequest")
     *  ),
     *  @OA\Response(
     *    response=204,
     *    description="success",
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
     *    description="Wrong credentials response",
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
    public function email(EmailRequest $emailRequest)
    {
        try {
            if(Email::where('email', $emailRequest->email)->count()==0){
                Email::create([
                    'email' => $emailRequest->email,
                ]);
            }
            return response()->json()->setStatusCode(204);
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }
}
