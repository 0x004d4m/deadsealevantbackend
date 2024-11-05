<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deadsea Levant - New Order From
        {{ $Order->customer ? $Order->customer->first_name . ' ' . $Order->customer->last_name : $Order->guest->first_name . ' ' . $Order->guest->last_name }}
    </title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.5; color: #333;">
    <h2>Order Details</h2>

    <p><strong>Order From:</strong>
        {{ $Order->customer ? $Order->customer->first_name . ' ' . $Order->customer->last_name : $Order->guest->first_name . ' ' . $Order->guest->last_name }}
    </p>
    <p><strong>Email:</strong> {{ $Order->customer->email ?? ($Order->guest->email ?? 'N/A') }}</p>
    <p><strong>Country:</strong> {{ $Order->customerAddress->country->name ?? ($Order->guest->country->name ?? 'N/A') }}
    </p>
    <p><strong>Phone Number:</strong>
        {{ $Order->customerAddress->phone_number ?? ($Order->guest->phone_number ?? 'N/A') }}</p>
    <p><strong>Address:</strong> {{ $Order->customerAddress->address ?? ($Order->guest->address ?? 'N/A') }}</p>
    <p><strong>Address Details:</strong>
        {{ $Order->customerAddress->address_details ?? ($Order->guest->address_details ?? 'N/A') }}</p>
    <p><strong>City:</strong> {{ $Order->customerAddress->city ?? ($Order->guest->city ?? 'N/A') }}</p>
    <p><strong>State:</strong> {{ $Order->customerAddress->state ?? ($Order->guest->state ?? 'N/A') }}</p>
    <p><strong>ZIP Code:</strong> {{ $Order->customerAddress->zip_code ?? ($Order->guest->zip_code ?? 'N/A') }}</p>

    <h3>Order Items</h3>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
            <tr>
                <th style="border: 1px solid #ddd; padding: 8px;">Image</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Product</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Price</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Quantity</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Order->carts as $cart)
                @php
                    $productTitle = $cart->product->title ?? 'N/A';
                    $quantity = $cart->quantity;
                    $price = $cart->product->price ?? 0;
                    $total = $quantity * $price;
                    $imageUrl = $cart->product->image ?? null;
                @endphp
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                        @if ($imageUrl)
                            <a href="{{ $imageUrl }}" target="_blank">
                                <img src="{{ $imageUrl }}" alt="{{ $productTitle }}"
                                    style="width: 50px; height: 50px; object-fit: cover;">
                            </a>
                        @else
                            No image available
                        @endif
                    </td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $productTitle }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">${{ number_format($price, 2) }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $quantity }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">${{ number_format($total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Order Total:</strong>
        ${{ number_format($Order->carts->sum(fn($cart) => $cart->quantity * ($cart->product->price ?? 0)), 2) }}</p>
</body>

</html>
