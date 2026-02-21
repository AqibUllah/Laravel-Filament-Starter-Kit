<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Payment Confirmed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #3498db;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
            border-top: none;
        }
        .order-details {
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 12px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
        .status-badge {
            background: #d4edda;
            color: #155724;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Payment Confirmed! 🎉</h1>
        <p>Thank you for your order</p>
    </div>

    <div class="content">
        <p>Dear {{ $customerName }},</p>
        
        <p>Great news! Your payment for order #{{ $order->order_number }} has been successfully processed. Your order is now being prepared for shipment.</p>

        <div class="order-details">
            <h3>Order Details</h3>
            <p><strong>Order Number:</strong> #{{ $order->order_number }}</p>
            <p><strong>Payment Status:</strong> <span class="status-badge">Paid</span></p>
            <p><strong>Order Status:</strong> {{ $order->order_status->getLabel() }}</p>
            <p><strong>Payment Method:</strong> {{ $order->payment_method->getLabel() }}</p>
            <p><strong>Total Amount:</strong> {{ $orderTotal }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
            
            @if($order->paid_at)
                <p><strong>Paid Date:</strong> {{ $order->paid_at->format('M d, Y') }}</p>
            @endif
        </div>

        <h4>Items Ordered:</h4>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f0f0f0;">
                    <th style="padding: 10px; text-align: left;">Product</th>
                    <th style="padding: 10px; text-align: center;">Quantity</th>
                    <th style="padding: 10px; text-align: right;">Price</th>
                    <th style="padding: 10px; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td style="padding: 10px;">{{ $item->product_name }}</td>
                        <td style="padding: 10px; text-align: center;">{{ $item->quantity }}</td>
                        <td style="padding: 10px; text-align: right;">{{ $item->getFormattedProductPrice() }}</td>
                        <td style="padding: 10px; text-align: right;">{{ $item->getFormattedTotalPrice() }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="padding: 10px; text-align: right; border-top: 2px solid #ddd;"><strong>Total:</strong></td>
                    <td style="padding: 10px; text-align: right; border-top: 2px solid #ddd;"><strong>{{ $orderTotal }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('orders.show', $order->id) }}" class="btn">View Order Details</a>
        </div>

        <p><strong>What happens next?</strong></p>
        <ul>
            <li>Your order will be processed and shipped within 1-2 business days</li>
            <li>You'll receive a shipping confirmation email with tracking information</li>
            <li>You can download your invoice from your order details page</li>
        </ul>

        @if($order->notes)
            <div style="background: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <strong>Additional Notes:</strong>
                <p>{{ $order->notes }}</p>
            </div>
        @endif
    </div>

    <div class="footer">
        <p>Thank you for choosing {{ config('app.name') }}!</p>
        <p>If you have any questions, please contact our support team.</p>
        <p>This is an automated message. Please do not reply to this email.</p>
    </div>
</body>
</html>
