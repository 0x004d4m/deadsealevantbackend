<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralException;
use App\Http\Requests\Customer\PaymentMethodRequest;
use App\Http\Resources\Customer\PaymentMethodResource;
use App\Models\CustomerPaymentMethod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="CustomerPaymentMethod",
 *     description="API Endpoints of Customer Payment Methods"
 * )
 */
class CustomerPaymentMethodController extends Controller
{
    /**
     * @OA\Get(
     *  path="/api/customers/payment_methods",
     *  summary="List Customer Payment Methods",
     *  description="Customer Payment Methods List",
     *  operationId="CustomerPaymentMethodList",
     *  tags={"CustomerPaymentMethod"},
     *  security={{"bearerAuth": {}}},
     *  @OA\Response(
     *    response=200,
     *    description="Returns a list of payment methods",
     *    @OA\JsonContent(
     *      @OA\Property(
     *        property="data",
     *        type="array",
     *        @OA\Items(ref="#/components/schemas/PaymentMethodResource")
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
    public function index(Request $request)
    {
        try {
            return PaymentMethodResource::collection(CustomerPaymentMethod::where('customer_id', $request->customer_id)->get());
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/customers/payment_methods",
     *  summary="Create Customer Payment Method",
     *  description="Create Customer Payment Method",
     *  operationId="CustomerPaymentMethodCreate",
     *  tags={"CustomerPaymentMethod"},
     *  security={{"bearerAuth": {}}},
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/PaymentMethodRequest")
     *  ),
     *  @OA\Response(
     *    response=201,
     *    description="Success",
     *    @OA\JsonContent(ref="#/components/schemas/PaymentMethodResource")
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
    public function store(PaymentMethodRequest $paymentMethodRequest)
    {
        try {
            $CustomerPaymentMethod = CustomerPaymentMethod::create([
                'customer_id' => $paymentMethodRequest->customer_id,
                'card_number' => $paymentMethodRequest->card_number,
                'expiry_month' => $paymentMethodRequest->expiry_month,
                'expiry_year' => $paymentMethodRequest->expiry_year,
                'cvv' => $paymentMethodRequest->cvv,
                'cardholder_name' => $paymentMethodRequest->cardholder_name,
            ]);
            return new PaymentMethodResource($CustomerPaymentMethod);
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }

    /**
     * @OA\Put(
     *  path="/api/customers/payment_methods/{id}",
     *  summary="Update Customer Payment Method",
     *  description="Customer Payment Method Update",
     *  operationId="CustomerPaymentMethodUpdate",
     *  tags={"CustomerPaymentMethod"},
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(
     *     name="id",
     *     description="Payment Method id",
     *     required=true,
     *     in="path",
     *     @OA\Schema(
     *         type="integer"
     *     )
     *  ),
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/PaymentMethodRequest")
     *  ),
     *  @OA\Response(
     *    response=204,
     *    description="Success",
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
    public function update(PaymentMethodRequest $paymentMethodRequest, $id)
    {
        try {
            $CustomerPaymentMethod = CustomerPaymentMethod::where('customer_id', $paymentMethodRequest->customer_id)->where('id', $id)->first();
            $CustomerPaymentMethod->update([
                'card_number' => $paymentMethodRequest->card_number,
                'expiry_month' => $paymentMethodRequest->expiry_month,
                'expiry_year' => $paymentMethodRequest->expiry_year,
                'cvv' => $paymentMethodRequest->cvv,
                'cardholder_name' => $paymentMethodRequest->cardholder_name,
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
     * @OA\Delete(
     *  path="/api/customers/payment_methods/{id}",
     *  summary="Delete a Customer Payment Method",
     *  description="Delete a Customer Payment Method",
     *  operationId="CustomerPaymentMethodDelete",
     *  tags={"CustomerPaymentMethod"},
     *  security={{"bearerAuth": {}}},
     *  @OA\Parameter(
     *     name="id",
     *     description="Payment Method id",
     *     required=true,
     *     in="path",
     *     @OA\Schema(
     *         type="integer"
     *     )
     *  ),
     *  @OA\Response(
     *    response=204,
     *    description="Success",
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
     *         @OA\Property(property="dynamic-error-keys", type="array",
     *           @OA\Items(type="string")
     *         )
     *       )
     *    )
     *  ),
     * )
     */
    public function destroy(Request $request, $id)
    {
        try {
            $CustomerPaymentMethod = CustomerPaymentMethod::where('customer_id', $request->customer_id)->where('id', $id)->first();
            $CustomerPaymentMethod->delete();
            return response()->json()->setStatusCode(204);
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }
}
