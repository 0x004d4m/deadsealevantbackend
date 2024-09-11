<?php

namespace App\Http\Controllers;

use App\Models\CustomerPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPaymentMethodController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'card_number' => 'required|string',
            'expiry_month' => 'required|string',
            'expiry_year' => 'required|string',
            'cvv' => 'required|string',
        ]);

        $cardDetail = new CustomerPaymentMethod([
            'user_id' => Auth::id(),
            'card_number_encrypted' => $validated['card_number'],
            'expiry_month' => $validated['expiry_month'],
            'expiry_year' => $validated['expiry_year'],
            'cvv' => $validated['cvv'],
        ]);

        $cardDetail->save();

        return response()->json($cardDetail, 201);
    }

    public function index()
    {
        $cardDetails = CustomerPaymentMethod::where('user_id', Auth::id())->get();

        return response()->json($cardDetails);
    }

    public function show($id)
    {
        $cardDetail = CustomerPaymentMethod::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        return response()->json($cardDetail);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'card_number' => 'required|string',
            'expiry_month' => 'required|string',
            'expiry_year' => 'required|string',
            'cvv' => 'required|string',
        ]);

        $cardDetail = CustomerPaymentMethod::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $cardDetail->update([
            'card_number_encrypted' => $validated['card_number'],
            'expiry_month' => $validated['expiry_month'],
            'expiry_year' => $validated['expiry_year'],
            'cvv' => $validated['cvv'],
        ]);

        return response()->json($cardDetail);
    }

    public function destroy($id)
    {
        $cardDetail = CustomerPaymentMethod::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cardDetail->delete();

        return response()->json(null, 204);
    }
}
