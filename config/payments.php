<?php

return [
    'stripe' => [
        'secret_key' => env('STRIPE_SECRET_KEY'),
        'publishable_key' => env('STRIPE_PUBLISHABLE_KEY'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    ],
    
    'jazzcash' => [
        'merchant_id' => env('JAZZCASH_MERCHANT_ID'),
        'password' => env('JAZZCASH_PASSWORD'),
        'secret_key' => env('JAZZCASH_SECRET_KEY'),
        'checkout_url' => env('JAZZCASH_CHECKOUT_URL', 'https://sandbox.jazzcash.com.pk/CheckoutPage'),
    ],
    
    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_CLIENT_SECRET'),
        'webhook_id' => env('PAYPAL_WEBHOOK_ID'),
        'cert_id' => env('PAYPAL_CERT_ID'),
        'sandbox' => env('PAYPAL_SANDBOX', true),
    ],
];
