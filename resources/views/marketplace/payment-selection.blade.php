@extends('layouts.app')

@section('title', 'Select Payment Method - Marketplace')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-32 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="max-w-7xl mx-auto mb-10 text-center">
            <h1 class="text-4xl font-extrabold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent mb-3">
                Select Payment Method
            </h1>
            <p class="text-lg text-gray-600">Choose how you'd like to pay for your orders</p>
        </div>

        <!-- Progress Steps -->
        <div class="max-w-2xl mx-auto mb-12">
            <div class="relative flex justify-between">
                <!-- Progress Line -->
                <div class="absolute top-5 left-0 w-full h-1 bg-gray-200 rounded-full"></div>
                <div class="absolute top-5 left-0 w-2/3 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition-all duration-500"></div>

                <!-- Step 1 -->
                <div class="relative flex flex-col items-center">
                    <div class="w-10 h-10 flex items-center justify-center bg-green-500 border-2 border-green-600 rounded-full shadow-lg z-10">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="mt-2 text-sm font-semibold text-green-600">Information</span>
                </div>

                <!-- Step 2 -->
                <div class="relative flex flex-col items-center">
                    <div class="w-10 h-10 flex items-center justify-center bg-blue-500 border-2 border-blue-600 rounded-full shadow-lg z-10">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <span class="mt-2 text-sm font-semibold text-blue-600">Payment</span>
                </div>

                <!-- Step 3 -->
                <div class="relative flex flex-col items-center">
                    <div class="w-10 h-10 flex items-center justify-center bg-white border-2 border-gray-300 rounded-full z-10">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="mt-2 text-sm font-medium text-gray-500">Confirmation</span>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Payment Methods Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Payment Methods</h2>

                    <!-- Payment Method Options -->
                    <div class="space-y-4">
                        <!-- Stripe/Credit Card -->
                        <div class="payment-method-card border-2 border-blue-500 bg-blue-50 rounded-xl p-6 cursor-pointer transition-all duration-200 hover:shadow-lg" data-method="stripe">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Credit/Debit Card</h3>
                                        <p class="text-sm text-gray-600">Pay securely with Visa, Mastercard, or American Express</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa" class="w-8 h-8">
                                    <img src="https://img.icons8.com/color/48/000000/mastercard.png" alt="Mastercard" class="w-8 h-8">
                                    <img src="https://img.icons8.com/color/48/000000/amex.png" alt="Amex" class="w-8 h-8">
                                </div>
                            </div>
                        </div>

                        <!-- PayPal -->
                        <div class="payment-method-card border-2 border-gray-200 bg-white rounded-xl p-6 cursor-pointer transition-all duration-200 hover:shadow-lg hover:border-blue-300" data-method="paypal">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-700 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944 2.419c.103-.464.462-.819.933-.819h7.654c2.603 0 4.808 1.927 5.09 4.456.082.726-.061 1.433-.371 2.046a4.01 4.01 0 0 1-1.114 1.362 4.414 4.414 0 0 1-1.873.82c-.286.047-.576.07-.866.07h-2.525l-.744 4.155a.641.641 0 0 1-.633.528h-2.527a.641.641 0 0 1-.633-.74l.743-4.155H9.38a.641.641 0 0 1-.633-.74l.743-4.155a.641.641 0 0 1 .633-.528h2.525c.29 0 .58-.023.866-.07a4.414 4.414 0 0 0 1.873-.82 4.01 4.01 0 0 0 1.114-1.362c.31-.613.453-1.32.371-2.046C16.339 3.527 14.134 1.6 11.531 1.6H3.877c-.471 0-.83.355-.933.819L.837 20.597a.641.641 0 0 0 .633.74h4.606l.743-4.155a.641.641 0 0 1 .633-.528h2.525a.641.641 0 0 1 .633.74l-.743 4.155h2.527a.641.641 0 0 0 .633-.528l.744-4.155h2.525c.29 0 .58.023.866.07a4.414 4.414 0 0 0 1.873-.82 4.01 4.01 0 0 0 1.114-1.362c.31-.613.453-1.32.371-2.046-.282-2.529-2.487-4.456-5.09-4.456H5.877c-.471 0-.83.355-.933.819L4.201 6.975a.641.641 0 0 0 .633.74h2.525l-.743 4.155a.641.641 0 0 1-.633.528H3.458l-.743 4.155a.641.641 0 0 0 .633.74h4.606l.743-4.155a.641.641 0 0 1 .633-.528h2.525a.641.641 0 0 1 .633.74l-.743 4.155z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">PayPal</h3>
                                    <p class="text-sm text-gray-600">Fast and secure payment with your PayPal account</p>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Transfer -->
                        <div class="payment-method-card border-2 border-gray-200 bg-white rounded-xl p-6 cursor-pointer transition-all duration-200 hover:shadow-lg hover:border-blue-300" data-method="bank">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Bank Transfer</h3>
                                    <p class="text-sm text-gray-600">Direct bank transfer (processing time: 1-3 business days)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Continue Button -->
                    <div class="mt-8">
                        <button id="continuePaymentBtn" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-4 px-6 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Continue to Payment
                        </button>
                    </div>
                </div>
            </div>

            <!-- Order Summary Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Order Summary</h2>

                    @foreach($orders as $order)
                        <div class="mb-6 pb-6 border-b border-gray-200 last:border-b-0 last:mb-0 last:pb-0">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-semibold text-gray-900">Order #{{ $order->order_number }}</h3>
                                    <p class="text-sm text-gray-600">{{ $order->team->name ?? 'Unknown Store' }}</p>
                                </div>
                                <span class="text-lg font-bold text-gray-900">{{ $order->getFormattedTotalAmount() }}</span>
                            </div>

                            <div class="space-y-2">
                                @foreach($order->items as $item)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">{{ $item->product_name }} × {{ $item->quantity }}</span>
                                        <span class="text-gray-900">{{ $order->currency }} {{ number_format($item->total_price, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <!-- Total -->
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-gray-900">{{ $orders->first()->currency }} {{ number_format($orders->sum('subtotal_amount'), 2) }}</span>
                        </div>
                        @if($orders->sum('tax_amount') > 0)
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Tax</span>
                                <span class="text-gray-900">{{ $orders->first()->currency }} {{ number_format($orders->sum('tax_amount'), 2) }}</span>
                            </div>
                        @endif
                        @if($orders->sum('discount_amount') > 0)
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Discount</span>
                                <span class="text-green-600">-{{ $orders->first()->currency }} {{ number_format($orders->sum('discount_amount'), 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="text-lg font-bold text-gray-900">{{ $orders->first()->currency }} {{ number_format($orders->sum('total_amount'), 2) }}</span>
                        </div>
                    </div>

                    <!-- Security Badge -->
                    <div class="mt-6 flex items-center justify-center space-x-2 text-sm text-gray-600">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Secure Payment</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden form for payment processing -->
    <form id="paymentForm" method="POST" action="{{ route('marketplace.payment.initiate', ['order' => $orders->first()->id]) }}" style="display: none;">
        @csrf
        <input type="hidden" name="payment_method" id="selectedPaymentMethod" value="">
        <input type="hidden" name="order_ids" value="{{ $orders->pluck('id')->implode(',') }}">
    </form>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-8 max-w-sm w-full mx-4">
            <div class="flex flex-col items-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Processing Payment</h3>
                <p class="text-sm text-gray-600 text-center">Please wait while we redirect you to the payment gateway...</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentCards = document.querySelectorAll('.payment-method-card');
    const continueBtn = document.getElementById('continuePaymentBtn');
    const paymentForm = document.getElementById('paymentForm');
    const selectedMethodInput = document.getElementById('selectedPaymentMethod');
    const loadingOverlay = document.getElementById('loadingOverlay');

    let selectedMethod = 'stripe'; // Default selection

    // Handle payment method selection
    paymentCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove active state from all cards
            paymentCards.forEach(c => {
                c.classList.remove('border-blue-500', 'bg-blue-50');
                c.classList.add('border-gray-200', 'bg-white');
            });

            // Add active state to selected card
            this.classList.remove('border-gray-200', 'bg-white');
            this.classList.add('border-blue-500', 'bg-blue-50');

            selectedMethod = this.dataset.method;
            selectedMethodInput.value = selectedMethod;
        });
    });

    // Handle continue button click
    continueBtn.addEventListener('click', async function() {
        // Show loading state
        this.innerHTML = '<div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white mr-2"></div> Processing...';
        this.disabled = true;
        this.classList.add('opacity-75', 'cursor-not-allowed');

        try {
            // Show loading overlay
            loadingOverlay.classList.remove('hidden');

            // Submit form via AJAX
            const formData = new FormData(paymentForm);
            const response = await fetch(paymentForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            });

            const result = await response.json();

            if (result.success && result.payment_url) {
                // Redirect to payment gateway
                window.location.href = result.payment_url;
            } else {
                // Hide loading and show error
                loadingOverlay.classList.add('hidden');
                this.innerHTML = 'Continue to Payment';
                this.disabled = false;
                this.classList.remove('opacity-75', 'cursor-not-allowed');

                // Show error message
                alert(result.message || 'Payment initiation failed. Please try again.');
            }
        } catch (error) {
            console.error('Payment error:', error);

            // Hide loading and show error
            loadingOverlay.classList.add('hidden');
            this.innerHTML = 'Continue to Payment';
            this.disabled = false;
            this.classList.remove('opacity-75', 'cursor-not-allowed');

            alert('Payment initiation failed. Please try again.');
        }
    });

    // Set initial active state
    const defaultCard = document.querySelector('[data-method="stripe"]');
    if (defaultCard) {
        defaultCard.classList.remove('border-gray-200', 'bg-white');
        defaultCard.classList.add('border-blue-500', 'bg-blue-50');
        selectedMethodInput.value = 'stripe';
    }
});
</script>
@endpush
