<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * @OA\Post(
     *  path="/api/orders",
     *  summary="Checkout From Cart",
     *  description="Checkout From Cart",
     *  operationId="OrderCreate",
     *  tags={"Order"},
     *  security={{"bearerAuth": {}}},
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/OrderRequest")
     *  ),
     *  @OA\Response(
     *    response=204,
     *    description="Success",
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
    public function store(Request $orderRequest)
    {
        try {
            // if ($cartRequest->customer_id) {
            //     if (Order::where('product_id', $cartRequest->product_id)->where('customer_id', $cartRequest->customer_id)->whereNull('order_id')->count() == 0) {
            //         Cart::create([
            //             'quantity' => $cartRequest->quantity,
            //             'product_id' => $cartRequest->product_id,
            //             'customer_id' => $cartRequest->customer_id,
            //         ]);
            //         return response()->json()->setStatusCode(204);
            //     } else {
            //         throw new GeneralException(['product_id' => ['Product already added in cart']]);
            //     }
            // }

            // if ($cartRequest->guest_id) {
            //     if (Cart::where('product_id', $cartRequest->product_id)->where('guest_id', $cartRequest->guest_id)->whereNull('order_id')->count() == 0) {
            //         Cart::create([
            //             'quantity' => $cartRequest->quantity,
            //             'product_id' => $cartRequest->product_id,
            //             'guest_id' => $cartRequest->guest_id,
            //         ]);
            //         return response()->json()->setStatusCode(204);
            //     } else {
            //         throw new GeneralException(['product_id' => ['Product already added in cart']]);
            //     }
            // }

            // $Guest = Guest::create([
            //     'access_token' => Str::random(60),
            // ]);
            // Cart::create([
            //     'quantity' => $cartRequest->quantity,
            //     'product_id' => $cartRequest->product_id,
            //     'guest_id' => $Guest->id,
            // ]);
            // return new RegisterResource($Guest);
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }
}
