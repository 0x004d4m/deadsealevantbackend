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
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(ref="#/components/schemas/MepsRedirectResource")
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
                $subtotal = $this->calculateSubtotal($orderRequest->customer_id, 'customer');
                $Order = $this->createOrder($orderRequest, $subtotal, 'customer');
                $this->attachCartsToOrder($orderRequest->customer_id, $Order->id, 'customer');
                return $this->initiatePayment($Order);
            }

            if ($orderRequest->guest_id) {
                $subtotal = $this->calculateSubtotal($orderRequest->guest_id, 'guest');
                $Order = $this->createOrder($orderRequest, $subtotal, 'guest');
                $this->attachCartsToOrder($orderRequest->guest_id, $Order->id, 'guest');
                $this->updateGuestDetails($orderRequest);
                return $this->initiatePayment($Order);
            }
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }

    /**
     * Calculate the subtotal for the order.
     */
    private function calculateSubtotal($id, $type)
    {
        $subtotal = 0;
        $carts = Cart::where($type . '_id', $id)->whereNull('order_id')->get();

        foreach ($carts as $Cart) {
            $subtotal += ($Cart->product->price * $Cart->quantity);
        }

        return $subtotal;
    }

    /**
     * Create the order and calculate taxes and shipping.
     */
    private function createOrder($request, $subtotal, $type)
    {
        $Setting = Setting::first();
        $tax = $Setting->tax;
        $shipping = ($subtotal > $Setting->shipping_free_after) ? 0 : $Setting->shipping;
        $subtotalTax = $subtotal * $Setting->tax;

        $orderData = [
            "{$type}_id" => $request->customer_id ?? $request->guest_id,
            'payment_id' => $this->generatePaymentReference(),
            'order_status_id' => 1,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => ($subtotal + $shipping + $subtotalTax),
        ];

        if ($type === 'customer') {
            $orderData['customer_address_id'] = $request->customer_address_id;
        }

        return Order::create($orderData);
    }

    /**
     * Attach carts to the created order.
     */
    private function attachCartsToOrder($id, $orderId, $type)
    {
        Cart::where($type . '_id', $id)
            ->whereNull('order_id')
            ->update(['order_id' => $orderId]);
    }

    /**
     * Update guest details.
     */
    private function updateGuestDetails($request)
    {
        Guest::where('id', $request->guest_id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'country_id' => $request->country_id,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'address_details' => $request->address_details,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
        ]);
    }

    private function generatePaymentReference()
    {
        $prefix = 'PMNT';
        $timePart1 = strtoupper(str_pad(dechex(date('Hi')), 4, '0', STR_PAD_LEFT));
        $milliseconds = (int) (microtime(true) * 1000);
        $timePart2 = strtoupper(substr(dechex($milliseconds), -8));
        $randomHexPart = sprintf('%08X', random_int(0, 4294967295));
        $reference = $prefix . $timePart1 . '.' . $timePart2 . '.' . $randomHexPart;
        return $reference;
    }

    /**
     * Initiate payment request to MEPS and redirect user to hosted payment page.
     */
    private function initiatePayment($Order)
    {
        $paymentData = [
            "profile_id" => env('MEPS_MERCHANT_PROFILE_ID'),
            "tran_type" => "sale",
            "tran_class" => "ecom",
            "cart_id" => $Order->payment_id,
            "cart_description" => "Order #{$Order->id}",
            "cart_currency" => "JOD",
            "cart_amount" => $Order->total,
            "callback" => route('payment.callback'),
            "return" => env('SITE_URL') . '/paymentReturn'
        ];

        $response = Http::withHeaders([
            'authorization' => env('MEPS_SERVER_KEY'),
            'content-type' => 'application/json'
        ])->post('https://secure-jordan.paytabs.com/payment/request', $paymentData);

        if ($response->successful()) {
            $result = $response->json();
            if (isset($result['redirect_url'])) {
                return response()->json(['redirect_url' => $result['redirect_url']]);
            }
        }

        throw new GeneralException(['order_id' => ['An unexpected error occurred']]);
    }

    public function paymentCallback(Request $request)
    {
        $data = $request->all();
        // $serverKey = env('MEPS_SERVER_KEY');
        // $requestSignature = $data['signature'] ?? null;
        // unset($data['signature']);
        ksort($data);
        // $query = http_build_query($data);
        // $generatedSignature = hash_hmac('sha256', $query, $serverKey);
        print_r($data);
        // if ($requestSignature && hash_equals($generatedSignature, $requestSignature)) {
            $order = Order::find('payment_id',$data['cartId']);

            if ($order) {
                if ($data['respStatus'] === 'A') {
                    $order->update([
                        'order_status_id' => 2,
                        'transaction_reference' => $data['tranRef'],
                        'response_message' => $data['respMessage'],
                    ]);
                    Log::info('Order #' . $order->id . ' payment successful.');
                } else {
                    $order->update([
                        'order_status_id' => 3,
                        'transaction_reference' => $data['tranRef'],
                        'response_message' => $data['respMessage'],
                    ]);
                    Log::error('Order #' . $order->id . ' payment failed.');
                }
                return response()->json(['status' => 'success'], 200);
            }
            Log::error('Order not found for cartId: ' . $data['cartId']);
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        // }
        // Log::error('Invalid signature in payment callback.');
        // return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 400);
    }
}
