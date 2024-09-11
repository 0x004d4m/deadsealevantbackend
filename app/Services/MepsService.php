<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MepsService
{
    protected $merchantId;
    protected $terminalId;
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->merchantId = config('services.meps.merchant_id');
        $this->terminalId = config('services.meps.terminal_id');
        $this->apiKey = config('services.meps.api_key');
        $this->apiUrl = config('services.meps.api_url');
    }

    public function initiatePayment($amount, $currency, $cardDetails)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->apiUrl . '/payment', [
            'merchant_id' => $this->merchantId,
            'terminal_id' => $this->terminalId,
            'amount' => $amount,
            'currency' => $currency,
            'card_details' => $cardDetails,
        ]);

        return $response->json();
    }

    public function saveCardDetails($cardDetails)
    {
        // Logic to save card details securely (possibly in an encrypted format)
    }
}
