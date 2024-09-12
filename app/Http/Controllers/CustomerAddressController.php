<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralException;
use App\Http\Requests\Customer\AddressRequest;
use App\Http\Resources\Customer\AddressResource;
use App\Models\CustomerAddress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="CustomerAddress",
 *     description="API Endpoints of Customer Address"
 * )
 */
class CustomerAddressController extends Controller
{
    /**
     * @OA\Get(
     *  path="/api/customers/addresses",
     *  summary="List Customer Addresses",
     *  description="Customer Address List",
     *  operationId="CustomerAddressList",
     *  tags={"CustomerAddress"},
     *  @OA\Response(
     *    response=200,
     *    description="Returns a list of addresses",
     *    @OA\JsonContent(
     *      @OA\Property(
     *        property="data",
     *        type="array",
     *        @OA\Items(ref="#/components/schemas/AddressResource")
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
            return AddressResource::collection(CustomerAddress::where('customer_id', $request->customer_id)->get());
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/customers/addresses",
     *  summary="Create Customer Address",
     *  description="Create Customer Address",
     *  operationId="CustomerAddressCreate",
     *  tags={"CustomerAddress"},
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/AddressRequest")
     *  ),
     *  @OA\Response(
     *    response=201,
     *    description="Success",
     *    @OA\JsonContent(ref="#/components/schemas/AddressResource")
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
    public function store(AddressRequest $addressRequest)
    {
        try {
            $CustomerAddress = CustomerAddress::create([
                'customer_id' => $addressRequest->customer_id,
                'country_id' => $addressRequest->country_id,
                'phone_number' => $addressRequest->phone_number,
                'address' => $addressRequest->address,
                'address_details' => $addressRequest->address_details,
                'city' => $addressRequest->city,
                'state' => $addressRequest->state,
                'zip_code' => $addressRequest->zip_code,
            ]);
            return new AddressResource($CustomerAddress);
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }

    /**
     * @OA\Put(
     *  path="/api/customers/addresses/{id}",
     *  summary="Update Customer Address",
     *  description="Customer Address Update",
     *  operationId="CustomerAddressUpdate",
     *  tags={"CustomerAddress"},
     *  @OA\Parameter(
     *     name="id",
     *     description="address id",
     *     required=true,
     *     in="path",
     *     @OA\Schema(
     *         type="integer"
     *     )
     *  ),
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/AddressRequest")
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
    public function update(AddressRequest $addressRequest, $id)
    {
        try {
            $CustomerAddress = CustomerAddress::where('customer_id', $addressRequest->customer_id)->where('id', $id)->first();
            $CustomerAddress->update([
                'country_id' => $addressRequest->country_id,
                'phone_number' => $addressRequest->phone_number,
                'address' => $addressRequest->address,
                'address_details' => $addressRequest->address_details,
                'city' => $addressRequest->city,
                'state' => $addressRequest->state,
                'zip_code' => $addressRequest->zip_code,
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
     *  path="/api/customers/addresses/{id}",
     *  summary="Delete a Customer Address",
     *  description="Delete a Customer Address",
     *  operationId="CustomerAddressDelete",
     *  tags={"CustomerAddress"},
     *  @OA\Parameter(
     *     name="id",
     *     description="Address id",
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
            $CustomerAddress = CustomerAddress::where('customer_id', $request->customer_id)->where('id', $id)->first();
            $CustomerAddress->delete();
            return response()->json()->setStatusCode(204);
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }
}
