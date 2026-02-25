# PayPal Integration

This application now supports PayPal payments using the `srmklive/laravel-paypal` package.

## Installation

The PayPal package has been installed and configured. The following components have been added:

### 1. Package Installation
```bash
composer require srmklive/paypal
```

### 2. Configuration
- Published PayPal configuration file: `config/paypal.php`
- Added environment variables to `.env.example`

### 3. Database Migration
- Added `paypal_order_id` column to the `orders` table for tracking PayPal transactions

### 4. Routes Added
- `GET /payment/paypal/return` - PayPal return callback
- `GET /payment/paypal/cancel` - PayPal cancel callback

### 5. Payment Service
- Updated `PayPalPaymentService` to use the srmklive/paypal package
- Supports order creation, payment capture, refunds, and webhooks

## Configuration

Add the following environment variables to your `.env` file:

```env
# PayPal Configuration
PAYPAL_MODE=sandbox
PAYPAL_SANDBOX_CLIENT_ID=your_paypal_sandbox_client_id
PAYPAL_SANDBOX_CLIENT_SECRET=your_paypal_sandbox_client_secret
PAYPAL_LIVE_CLIENT_ID=your_paypal_live_client_id
PAYPAL_LIVE_CLIENT_SECRET=your_paypal_live_client_secret
PAYPAL_PAYMENT_ACTION=Sale
PAYPAL_CURRENCY=USD
PAYPAL_NOTIFY_URL=
PAYPAL_LOCALE=en_US
PAYPAL_VALIDATE_SSL=true
```

## Usage

### Creating a PayPal Checkout Session

```php
use App\Services\Payments\PayPalPaymentService;

$service = new PayPalPaymentService();
$result = $service->createCheckoutSession($order);

if ($result['success']) {
    $approvalUrl = $result['approval_url'];
    // Redirect user to PayPal for approval
}
```

### Processing PayPal Payment

The payment is processed automatically when the user returns from PayPal via the return URL.

### Webhooks

PayPal webhooks are handled through the `handleWebhook` method in the `PayPalPaymentService`.

## Testing

The PayPal integration includes tests to verify:

- Service configuration
- Database storage of PayPal order IDs
- Route definitions

Run tests with:
```bash
php artisan test --filter PayPalPaymentServiceTest
```

## PayPal Developer Setup

1. Create a PayPal Developer account at https://developer.paypal.com/
2. Create a new application in the PayPal Developer Dashboard
3. Get your Client ID and Client Secret for sandbox mode
4. Add the environment variables to your `.env` file
5. For production, create a live application and use the live credentials

## Features

- ✅ PayPal order creation
- ✅ Payment capture
- ✅ Refunds
- ✅ Webhook handling
- ✅ Order status tracking
- ✅ Error handling and logging
- ✅ Database integration with order tracking

## Security Notes

- Never commit PayPal credentials to version control
- Use environment variables for all PayPal configuration
- Enable SSL validation in production (`PAYPAL_VALIDATE_SSL=true`)
- Implement proper webhook signature verification for production

## Support

For issues with the PayPal package itself, refer to:
- GitHub Repository: https://github.com/srmklive/laravel-paypal
- Documentation: https://srmklive.github.io/laravel-paypal/
