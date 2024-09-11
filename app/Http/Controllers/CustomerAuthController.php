<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralException;
use App\Http\Requests\Customer\{ForgetOtpRequest, ForgetRequest, LoginRequest, RegisterOtpRequest, RegisterRequest, ResetPasswordRequest};
use App\Http\Resources\Customer\{ForgetOtpResource, ForgetResource, CustomerResource, RegisterResource};
use App\Mail\{ForgetMail, RegisterMail};
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Log, Mail};
use Illuminate\Support\Str;

/**
 * @OA\Tag(
 *     name="CustomerAuth",
 *     description="API Endpoints of Customer Auth"
 * )
 */
class CustomerAuthController extends Controller
{
    /**
     * @OA\Post(
     *  path="/api/customers/register",
     *  summary="Register a Customer",
     *  description="Register a Customer",
     *  operationId="CustomerAuthRegister",
     *  tags={"CustomerAuth"},
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
     *  ),
     *  @OA\Response(
     *    response=201,
     *    description="success",
     *    @OA\JsonContent(ref="#/components/schemas/RegisterResource")
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
    public function register(RegisterRequest $registerRequest)
    {
        try {
            $Customer = Customer::create([
                'username' => $registerRequest->username,
                'email' => $registerRequest->email,
                'password' => Hash::make($registerRequest->password),
            ]);
            if ($Customer) {
                $Customer->update([
                    'email_token' => Str::random(60),
                    'email_code' => random_int(100000, 999999),
                ]);
                Mail::to($Customer->email)->send(new RegisterMail($Customer));
            }
            return new RegisterResource($Customer);
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/customers/register_otp",
     *  summary="Customer Register OTP",
     *  description="Customer Register OTP",
     *  operationId="CustomerAuthRegisterOtp",
     *  tags={"CustomerAuth"},
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/RegisterOtpRequest")
     *  ),
     *  @OA\Response(
     *    response=201,
     *    description="success",
     *    @OA\JsonContent(ref="#/components/schemas/CustomerResource")
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
    public function registerOtp(RegisterOtpRequest $registerOtpRequest)
    {
        try {
            $Customer = Customer::where('email_token', $registerOtpRequest->token)->where('email_code', $registerOtpRequest->code)->first();
            $Customer->update([
                'email_token' => null,
                'email_code' => null,
                'email_verified' => 1,
                'access_token' => Str::random(60),
            ]);
            return new CustomerResource($Customer);
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/customers/login",
     *  summary="Customer Login",
     *  description="Customer Login",
     *  operationId="CustomerAuthLogin",
     *  tags={"CustomerAuth"},
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *  ),
     *  @OA\Response(
     *    response=201,
     *    description="success",
     *    @OA\JsonContent(ref="#/components/schemas/CustomerResource")
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
    public function login(LoginRequest $loginRequest)
    {
        try {
            $Customer = Customer::where('email', $loginRequest->user)->orWhere('username', $loginRequest->user)->first();
            if (Hash::check($loginRequest->password, $Customer->password)) {
                $Customer->update([
                    'access_token' => Str::random(60),
                ]);
                return new CustomerResource($Customer);
            } else {
                throw new GeneralException(['password' => ['Password is incorrect']]);
            }
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/customers/logout",
     *  summary="Customer Logout",
     *  description="Customer Logout",
     *  operationId="CustomerAuthLogout",
     *  tags={"CustomerAuth"},
     *  security={{"bearerAuth": {}}},
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
    public function logout(Request $request)
    {
        try {
            $Customer = Customer::where('id', $request->customer_id)->first();
            $Customer->update([
                'access_token' => null,
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
     * @OA\Post(
     *  path="/api/customers/forget",
     *  summary="Customer Forget",
     *  description="Customer Forget",
     *  operationId="CustomerAuthForget",
     *  tags={"CustomerAuth"},
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/ForgetRequest")
     *  ),
     *  @OA\Response(
     *    response=201,
     *    description="success",
     *    @OA\JsonContent(ref="#/components/schemas/ForgetResource")
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
    public function forget(ForgetRequest $forgetRequest)
    {
        try {
            $Customer = Customer::where('email', $forgetRequest->user)->orWhere('username', $forgetRequest->user)->first();
            $Customer->update([
                'forget_token' => Str::random(60),
                'forget_code' => random_int(100000, 999999),
            ]);
            Mail::to($Customer->email)->send(new ForgetMail($Customer));
            return new ForgetResource($Customer);
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/customers/forget_otp",
     *  summary="Customer Forget OTP",
     *  description="Customer Forget OTP",
     *  operationId="CustomerAuthForgetOtp",
     *  tags={"CustomerAuth"},
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/ForgetOtpRequest")
     *  ),
     *  @OA\Response(
     *    response=201,
     *    description="success",
     *    @OA\JsonContent(ref="#/components/schemas/ForgetOtpResource")
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
    public function forgetOtp(ForgetOtpRequest $forgetOtpRequest)
    {
        try {
            $Customer = Customer::where('forget_token', $forgetOtpRequest->token)->orWhere('forget_code', $forgetOtpRequest->code)->first();
            $Customer->update([
                'forget_token' => Str::random(60),
                'forget_code' => null,
            ]);
            return new ForgetOtpResource($Customer);
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }

    /**
     * @OA\Post(
     *  path="/api/customers/reset_password",
     *  summary="Customer Reset Password",
     *  description="Customer Reset Password",
     *  operationId="CustomerAuthResetPassword",
     *  tags={"CustomerAuth"},
     *  @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/ResetPasswordRequest")
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
    public function resetPassword(ResetPasswordRequest $resetPasswordRequest)
    {
        try {
            Log::debug('hi');
            $Customer = Customer::where('forget_token', $resetPasswordRequest->token)->first();

            $Customer->update([
                'forget_token' => null,
                'forget_code' => null,
                'password' => Hash::make($resetPasswordRequest->password),
            ]);

            return response()->json()->setStatusCode(204);
        } catch (GeneralException $e) {
            return $e->render();
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json(["error" => [$e->getMessage()]], 500);
        }
    }
}
