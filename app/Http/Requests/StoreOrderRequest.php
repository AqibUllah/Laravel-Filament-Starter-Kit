<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:stripe,jazzcash,paypal',
            'billing_address' => 'required|array',
            'billing_address.first_name' => 'required|string|max:255',
            'billing_address.last_name' => 'required|string|max:255',
            'billing_address.email' => 'required|email|max:255',
            'billing_address.phone' => 'required|string|max:20',
            'billing_address.address' => 'required|string|max:255',
            'billing_address.city' => 'required|string|max:255',
            'billing_address.state' => 'required|string|max:255',
            'billing_address.postal_code' => 'required|string|max:20',
            'billing_address.country' => 'required|string|max:2',
            'shipping_address' => 'nullable|array',
            'shipping_address.first_name' => 'required_with:shipping_address|string|max:255',
            'shipping_address.last_name' => 'required_with:shipping_address|string|max:255',
            'shipping_address.phone' => 'required_with:shipping_address|string|max:20',
            'shipping_address.address' => 'required_with:shipping_address|string|max:255',
            'shipping_address.city' => 'required_with:shipping_address|string|max:255',
            'shipping_address.state' => 'required_with:shipping_address|string|max:255',
            'shipping_address.postal_code' => 'required_with:shipping_address|string|max:20',
            'shipping_address.country' => 'required_with:shipping_address|string|max:2',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Your cart is empty. Please add items to create an order.',
            'items.min' => 'Your cart is empty. Please add items to create an order.',
            'items.*.product_id.exists' => 'One or more products are not available.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
            'billing_address.required' => 'Billing address is required.',
            'payment_method.in' => 'Invalid payment method selected.',
        ];
    }

    public function getShippingAddress(): ?array
    {
        return $this->input('shipping_address') ?: $this->input('billing_address');
    }
}
