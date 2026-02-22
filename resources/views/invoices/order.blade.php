<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #3498db;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-info h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 28px;
        }

        .company-info p {
            margin: 5px 0;
            color: #7f8c8d;
        }

        .invoice-details {
            text-align: right;
        }

        .invoice-details h2 {
            color: #3498db;
            margin: 0;
            font-size: 24px;
        }

        .invoice-details p {
            margin: 5px 0;
            color: #7f8c8d;
        }

        .addresses {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 20px;
        }

        .address-block {
            flex: 1;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .address-block h3 {
            margin: 0 0 10px 0;
            color: #2c3e50;
            font-size: 16px;
        }

        .address-block p {
            margin: 5px 0;
            color: #7f8c8d;
        }

        .order-items {
            margin-bottom: 30px;
        }

        .order-items table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .order-items th {
            background: #3498db;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }

        .order-items td {
            padding: 12px;
            border-bottom: 1px solid #ecf0f1;
        }

        .order-items tr:last-child td {
            border-bottom: none;
        }

        .order-items .text-right {
            text-align: right;
        }

        .totals {
            text-align: right;
            margin-top: 20px;
        }

        .totals table {
            width: 300px;
            border-collapse: collapse;
            margin-left: auto;
        }

        .totals td {
            padding: 8px;
        }

        .totals .total-row {
            border-top: 2px solid #3498db;
            font-weight: bold;
            font-size: 18px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-paid {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-shipped {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ecf0f1;
            text-align: center;
            color: #7f8c8d;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <div class="company-info">
                <h1>{{ $order->team->name ?? config('app.name') }}</h1>
                <p>{{ $order->team->description ?? 'Your SaaS Platform' }}</p>
                @if($order->team->domain)
                    <p>{{ $order->team->domain }}</p>
                @endif
            </div>
            <div class="invoice-details">
                <h2>INVOICE</h2>
                <p><strong>Invoice #:</strong> {{ $order->order_number }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                <p><strong>Status:</strong>
                    <span class="status-badge status-{{ $order->order_status->value }}">
                        {{ $order->order_status->getLabel() }}
                    </span>
                </p>
                @if($order->paid_at)
                    <p><strong>Paid Date:</strong> {{ $order->paid_at->format('M d, Y') }}</p>
                @endif
            </div>
        </div>

        <div class="addresses">
            <div class="address-block">
                <h3>Billing Address</h3>
                @if($billingAddress)
                    <p>{{ $billingAddress['first_name'] }} {{ $billingAddress['last_name'] }}</p>
                    <p>{{ $billingAddress['email'] }}</p>
                    <p>{{ $billingAddress['phone'] ?? 'N/A' }}</p>
                    <p>{{ $billingAddress['address'] }}</p>
                    <p>{{ $billingAddress['city'] }}, {{ $billingAddress['state'] }} {{ $billingAddress['postal_code'] }}</p>
                    <p>{{ $billingAddress['country'] }}</p>
                @else
                    <p>No billing address provided</p>
                @endif
            </div>
            <div class="address-block">
                <h3>Shipping Address</h3>
                @if($shippingAddress)
                    <p>{{ $shippingAddress['first_name'] }} {{ $shippingAddress['last_name'] }}</p>
                    <p>{{ $shippingAddress['phone'] ?? 'N/A'}}</p>
                    <p>{{ $shippingAddress['address'] }}</p>
                    <p>{{ $shippingAddress['city'] }}, {{ $shippingAddress['state'] }} {{ $shippingAddress['postal_code'] }}</p>
                    <p>{{ $shippingAddress['country'] }}</p>
                @else
                    <p>Same as billing address</p>
                @endif
            </div>
        </div>

        <div class="order-items">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Quantity</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->product->sku ?? 'N/A' }}</td>
                            <td class="text-right">{{ $item->getFormattedProductPrice() }}</td>
                            <td class="text-right">{{ $item->quantity }}</td>
                            <td class="text-right">{{ $item->getFormattedTotalPrice() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="totals">
                <table>
                    <tr>
                        <td>Subtotal:</td>
                        <td class="text-right">{{ $order->getFormattedSubtotalAmount() }}</td>
                    </tr>
                    @if($order->tax_amount)
                        <tr>
                            <td>Tax (8%):</td>
                            <td class="text-right">{{ $order->getFormattedTaxAmount() }}</td>
                        </tr>
                    @endif
                    @if($order->discount_amount)
                        <tr>
                            <td>Discount:</td>
                            <td class="text-right">-{{ $order->getFormattedDiscountAmount() }}</td>
                        </tr>
                    @endif
                    <tr class="total-row">
                        <td>Total:</td>
                        <td class="text-right">{{ $order->getFormattedTotalAmount() }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($order->notes)
            <div style="margin-bottom: 30px;">
                <h3>Notes</h3>
                <p>{{ $order->notes }}</p>
            </div>
        @endif

        <div class="footer">
            <p><strong>Payment Method:</strong> {{ $order->payment_method->getLabel() }}</p>
            @if($order->transaction_id)
                <p><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p>
            @endif
            <p>Thank you for your business!</p>
            <p>This is a computer-generated invoice and does not require a signature.</p>
        </div>
    </div>
</body>
</html>
