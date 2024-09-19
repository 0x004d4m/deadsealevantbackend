<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralException;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\Guest\RegisterResource;
use App\Models\Cart;
use App\Models\Guest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * @OA\Tag(
 *     name="Cart",
 *     description="API Endpoints of Cart"
 * )
 */
class CartController extends Controller
{
    /**
     * @OA\Get(
     *  path="/api/carts",
     *  summary="List Cart Items",
     *  description="Cart Items List",
     *  operationId="CartList",
     *  tags={"Cart"},
     *  security={{"bearerAuth": {}}},
     *  @OA\Response(
     *    response=200,
     *    description="Returns a list of cart items",
     *    @OA\JsonContent(
     *      @OA\Property(
     *        property="data",
     *        type="array",
     *        @OA\Items(ref="#/components/schemas/CartResource")
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
            if ($request->customer_id) {
                if (Cart::where('customer_id', $request->customer_id)->whereNull('order_id')->count() > 0) {
                    return CartResource::collection(Cart::where('customer_id', $request->customer_id)->whereNull('order_id')->get());
                }
            }

            if ($request->guest_id) {
                if (Cart::where('guest_id', $request->guest_id)->whereNull('order_id')->count() > 0) {
                    return CartResource::collection(Cart::where('guest_id', $request->guest_id)->whereNull('order_id')->get());
                }
            }

            return CartResource::collection([]);
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/carts",
     *  summary="Add Item To Cart Or Alter Item In Cart",
     *  description="Alter Cart",
     *  operationId="CartCreateOrAlter",
     *  tags={"Cart"},
     *  security={{"bearerAuth": {}}},
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/CartRequest")
     *  ),
     *  @OA\Response(
     *    response=204,
     *    description="Success",
     *  ),
     *  @OA\Response(
     *    response=201,
     *    description="Success",
     *    @OA\JsonContent(ref="#/components/schemas/GuestRegisterResource")
     *  ),
     *  @OA\Response(
     *    response=401,
     *    description="Unauthorized",
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
    public function store(CartRequest $cartRequest)
    {
        try {
            if ($cartRequest->customer_id) {
                $Cart = Cart::where('product_id', $cartRequest->product_id)->where('customer_id', $cartRequest->customer_id)->whereNull('order_id')->first();
                if (!$Cart) {
                    Cart::create([
                        'quantity' => $cartRequest->quantity,
                        'product_id' => $cartRequest->product_id,
                        'customer_id' => $cartRequest->customer_id,
                    ]);
                    return response()->json()->setStatusCode(204);
                } else {
                    if($cartRequest->quantity == 0){
                        $Cart->delete();
                    }else{
                        $Cart->update([
                            'quantity' => $cartRequest->quantity,
                        ]);
                    }
                }
            }

            if ($cartRequest->guest_id) {
                $Cart = Cart::where('product_id', $cartRequest->product_id)->where('guest_id', $cartRequest->guest_id)->whereNull('order_id')->first();
                if (!$Cart) {
                    Cart::create([
                        'quantity' => $cartRequest->quantity,
                        'product_id' => $cartRequest->product_id,
                        'guest_id' => $cartRequest->guest_id,
                    ]);
                    return response()->json()->setStatusCode(204);
                } else {
                    if ($cartRequest->quantity == 0) {
                        $Cart->delete();
                    } else {
                        $Cart->update([
                            'quantity' => $cartRequest->quantity,
                        ]);
                    }
                }
            }

            $Guest = Guest::create([
                'access_token' => Str::random(60),
            ]);
            Cart::create([
                'quantity' => $cartRequest->quantity,
                'product_id' => $cartRequest->product_id,
                'guest_id' => $Guest->id,
            ]);
            return new RegisterResource($Guest);
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }
}
