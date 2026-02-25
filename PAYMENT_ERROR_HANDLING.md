# Payment Error Handling

The payment selection page now includes comprehensive error handling to provide users with clear feedback when payment issues occur.

## Features

### 1. Dual-State Overlay
The loading overlay now supports two states:
- **Loading State**: Shows animated spinner while processing payment
- **Error State**: Displays detailed error information with retry options

### 2. Error Information Display
- **Error Title**: Clear, descriptive error heading
- **Error Message**: User-friendly explanation of what went wrong
- **Error Details**: Optional technical details (shown for debugging)
- **Action Buttons**: Retry and Cancel options

### 3. Error Types Handled
- **Payment Failed**: Payment gateway rejected the transaction
- **Network Error**: Unable to connect to payment server
- **Validation Error**: Invalid payment method or parameters
- **Server Error**: Internal server issues

### 4. User Experience Features
- **Smooth Animations**: Entrance/exit animations for all states
- **Keyboard Support**: ESC key closes error overlay
- **Auto-retry**: Retry button re-attempts the payment
- **Session Flash Messages**: Shows errors returned from server redirects

## Implementation Details

### Frontend JavaScript Functions

#### `showLoading()`
Displays the loading state with animated spinner.

#### `showError(title, message, details)`
Shows error state with customizable title, message, and optional technical details.

#### `hideOverlay()`
Smoothly hides the overlay with exit animation.

### Backend Integration

The controller returns structured JSON responses:

```json
{
    "success": false,
    "message": "User-friendly error message",
    "error": "Technical error details"
}
```

### Error Flow

1. User clicks "Continue to Payment"
2. Loading overlay appears
3. AJAX request is sent to server
4. If successful: Redirect to payment gateway
5. If error: Show error overlay with details
6. User can retry or cancel

## Styling

The error overlay uses:
- **Red color scheme** for error states
- **Animated icons** with pulsing effects
- **Responsive design** for mobile devices
- **Dark mode support** with appropriate color adjustments

## Testing

Error handling is covered by tests in:
- `PaymentErrorHandlingTest.php`
- Tests verify error display, JSON responses, and flash messages

## Usage Examples

### Displaying Custom Errors
```javascript
showError(
    'Payment Method Not Available',
    'The selected payment method is currently unavailable. Please try another payment method.',
    'Payment gateway returned: METHOD_NOT_SUPPORTED'
);
```

### Handling Network Errors
```javascript
showError(
    'Network Error',
    'Unable to connect to payment server. Please check your internet connection and try again.',
    error.message
);
```

### Flash Messages from Backend
```php
// In controller
return redirect()->back()->with('error', 'Payment failed: Invalid credentials');

// Automatically displayed on page load
```

## Best Practices

1. **User-Friendly Messages**: Always provide clear, non-technical error messages
2. **Actionable Solutions**: Include retry options when appropriate
3. **Logging**: Log technical errors for debugging while showing user-friendly messages
4. **Graceful Degradation**: Ensure the page works even if JavaScript fails
5. **Accessibility**: Ensure error messages are screen-reader friendly

## Future Enhancements

- **Error Categories**: Different styling for different error types
- **Help Links**: Direct users to help documentation for common issues
- **Error Reporting**: Allow users to report persistent errors
- **Retry Limits**: Implement automatic retry with exponential backoff
- **Payment Method Fallback**: Suggest alternative payment methods
