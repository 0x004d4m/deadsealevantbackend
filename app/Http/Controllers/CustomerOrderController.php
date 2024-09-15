<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralException;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="CustomerOrder",
 *     description="API Endpoints of Customer Order"
 * )
 */
class CustomerOrderController extends Controller
{
    /**
     * @OA\Get(
     *  path="/api/customers/orders",
     *  summary="List Customer Orders",
     *  description="Customer Orders List",
     *  operationId="CustomerOrderList",
     *  tags={"CustomerOrder"},
     *  security={{"bearerAuth": {}}},
     *  @OA\Response(
     *    response=200,
     *    description="Returns a list of Customer Orders",
     *    @OA\JsonContent(
     *      @OA\Property(
     *        property="data",
     *        type="array",
     *        @OA\Items(ref="#/components/schemas/CustomerOrderResource")
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
     *    response=401,
     *    description="Unauthorized",
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
        try {
            return OrderResource::collection(Order::where('customer_id', $request->customer_id)->get());
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }
}
