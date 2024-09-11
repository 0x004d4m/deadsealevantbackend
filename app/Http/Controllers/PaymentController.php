<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MepsService;

class PaymentController extends Controller
{
    protected $mepsService;

    public function __construct(MepsService $mepsService)
    {
        $this->mepsService = $mepsService;
    }

    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'card_number' => 'required|string',
            'expiry_month' => 'required|string',
            'expiry_year' => 'required|string',
            'cvv' => 'required|string',
        ]);

        $cardDetails = [
            'card_number' => $validated['card_number'],
            'expiry_month' => $validated['expiry_month'],
            'expiry_year' => $validated['expiry_year'],
            'cvv' => $validated['cvv'],
        ];

        // Optional: Save card details
        $this->mepsService->saveCardDetails($cardDetails);

        // Process the payment
        $response = $this->mepsService->initiatePayment($validated['amount'], $validated['currency'], $cardDetails);

        return response()->json($response);
    }
}
