<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralException;
use App\Models\Cart;
use App\Models\Guest;
use App\Models\Order;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="Order",
 *     description="API Endpoints of Order"
 * )
 */
class OrderController extends Controller
{
    private function createPayment($amount, $cart_id, $order_id){
        $response = Http::withHeaders([
            'authorization' => env('MEPS_SERVER_KEY'),
            'content-type' => 'application/json',
        ])->post('https://secure-jordan.paytabs.com/payment/request', [
            'profile_id' => env('MEPS_MERCHANT_PROFILE_ID'),
            'tran_type' => 'sale',
            'tran_class' => 'ecom',
            'cart_id' => '4244b9fd-c7e9-4f16-8d3c-4fe7bf6c48ca',
            'cart_description' => 'Order # ' . $order_id,
            'cart_currency' => 'USD',
            'cart_amount' => $amount,
            'callback' => url(''),
            'return' => env('SITE_URL'). '/payment_return'
        ]);

        // Check for successful response
        if ($response->successful()) {
            return $response->json();
        } else {
            return response()->json(['error' => 'Payment request failed'], 500);
        }
    }
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
            if ($orderRequest->customer_id) {
                $subtotal = 0;
                foreach (Cart::where('customer_id', $orderRequest->customer_id)->whereNull('order_id')->get() as $Cart) {
                    $subtotal += ($Cart->product->price * $Cart->quantity);
                }
                $Setting = Setting::first();
                $tax = $Setting->tax;
                $shipping = ($subtotal > $Setting->shipping_free_after) ? 0 : $Setting->shipping;
                $subtotalTax = $subtotal * $Setting->tax;
                $Order = Order::create([
                    'customer_id' => $orderRequest->customer_id,
                    'customer_address_id' => $orderRequest->customer_address_id,
                    'order_status_id' => 1,
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'shipping' => $shipping,
                    'total' => ($subtotal + $shipping + $subtotalTax),
                ]);
                foreach (Cart::where('customer_id', $orderRequest->customer_id)->whereNull('order_id')->get() as $Cart) {
                    $Cart->update([
                        'order_id' => $Order->id
                    ]);
                }
                return response()->json()->setStatusCode(204);
            }

            if ($orderRequest->guest_id) {
                $Guest = Guest::where('id', $orderRequest->guest_id)->first();
                $subtotal = 0;
                foreach (Cart::where('guest_id', $orderRequest->guest_id)->whereNull('order_id')->get() as $Cart) {
                    $subtotal += ($Cart->product->price * $Cart->quantity);
                }
                $Setting = Setting::first();
                $tax = $Setting->tax;
                $shipping = ($subtotal > $Setting->shipping_free_after) ? 0 : $Setting->shipping;
                $subtotalTax = $subtotal * $Setting->tax;
                $Order = Order::create([
                    'guest_id' => $orderRequest->guest_id,
                    'order_status_id' => 1,
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'shipping' => $shipping,
                    'total' => ($subtotal + $shipping + $subtotalTax),
                ]);
                foreach (Cart::where('guest_id', $orderRequest->guest_id)->whereNull('order_id')->get() as $Cart) {
                    $Cart->update([
                        'order_id' => $Order->id
                    ]);
                }
                $Guest->update([
                    'first_name' => $orderRequest->first_name,
                    'last_name' => $orderRequest->last_name,
                    'country_id' => $orderRequest->country_id,
                    'phone_number' => $orderRequest->phone_number,
                    'address' => $orderRequest->address,
                    'address_details' => $orderRequest->address_details,
                    'city' => $orderRequest->city,
                    'state' => $orderRequest->state,
                    'zip_code' => $orderRequest->zip_code,
                ]);
                return response()->json()->setStatusCode(204);
            }
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }
}
