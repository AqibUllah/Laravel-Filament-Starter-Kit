<!-- Shopping Cart Drawer -->
{{--    <div id="cart-drawer" class="fixed inset-0 overflow-hidden z-50" style="display: none;">--}}
{{--        <div class="absolute inset-0 overflow-hidden">--}}
{{--            <div class="absolute inset-0  bg-opacity-30 backdrop-blur-xs transition-opacity" onclick="toggleCart()"></div>--}}

{{--            <div id="cart-panel" class="fixed inset-y-0 right-0 pl-10 max-w-full flex transform translate-x-full transition-transform duration-500 ease-in-out">--}}
{{--                <div class="w-screen max-w-md h-full flex flex-col bg-white shadow-xl">--}}
{{--                    <div class="flex-1 py-6 overflow-y-auto px-4 sm:px-6">--}}
{{--                        <div class="flex items-start justify-between">--}}
{{--                            <h2 class="text-lg font-medium text-gray-900">Shopping Cart</h2>--}}
{{--                            <button onclick="toggleCart()" class="ml-3 h-7 flex items-center">--}}
{{--                                <svg class="h-6 w-6 text-gray-400 hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>--}}
{{--                                </svg>--}}
{{--                            </button>--}}
{{--                        </div>--}}

{{--                        <div class="mt-8" id="cart-content">--}}
{{--                            <!-- Cart items will be loaded here -->--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                        <div class="border-t border-gray-200 py-6 px-4 sm:px-6">--}}
{{--                            <div class="flex justify-between text-base font-medium text-gray-900">--}}
{{--                                <p>Subtotal</p>--}}
{{--                                <p id="cart-subtotal">$0.00</p>--}}
{{--                            </div>--}}
{{--                            <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>--}}
{{--                            <div class="mt-6">--}}
{{--                                <a href="{{ route('marketplace.checkout') }}" class="flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700">--}}
{{--                                    Checkout--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="mt-6 flex justify-center text-sm text-center text-gray-500">--}}
{{--                                <p>or <button @click="open = false" class="text-blue-600 font-medium hover:text-blue-500">Continue Shopping<span aria-hidden="true"> →</span></button></p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}


<!-- Shopping Cart Drawer -->
<div id="cart-drawer" class="fixed inset-0 overflow-hidden z-50" style="display: none;">
    <div class="absolute inset-0 overflow-hidden">
        <!-- Backdrop with blur effect - Fixed missing bg class -->
        <div class="absolute inset-0   bg-opacity-50 dark:bg-opacity-70 backdrop-blur-sm transition-opacity duration-300" onclick="toggleCart()"></div>

        <!-- Cart Panel -->
        <div id="cart-panel" class="fixed inset-y-0 right-0 pl-10 max-w-full flex transform transition-transform duration-500 ease-out">
            <div class="w-screen max-w-md h-full flex flex-col bg-white dark:bg-gray-900 shadow-2xl dark:shadow-gray-950/50">
                <!-- Header with gradient -->
                <div class="relative px-6 py-8 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-600 dark:to-pink-600 overflow-hidden">
                    <!-- Decorative elements -->
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-10 dark:opacity-20 rounded-full blur-2xl animate-pulse-slow"></div>
                    <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-purple-400 dark:bg-pink-400 opacity-10 dark:opacity-20 rounded-full blur-2xl animate-pulse-slow animation-delay-1000"></div>

                    <!-- Floating particles -->
                    <div class="absolute inset-0 overflow-hidden">
                        @for ($i = 0; $i < 5; $i++)
                            <div class="absolute w-1 h-1 bg-white/30 rounded-full animate-float-particle"
                                 style="top: {{ rand(0, 100) }}%; left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
                        @endfor
                    </div>

                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-white/20 dark:bg-white/10 rounded-lg backdrop-blur-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">Your Cart</h2>
                                <p class="text-sm text-blue-100 dark:text-purple-200" id="cart-item-count">Loading...</p>
                            </div>
                        </div>
                        <button onclick="toggleCart()" class="p-2 hover:bg-white/20 dark:hover:bg-white/10 rounded-lg transition-all duration-200 group relative overflow-hidden">
                            <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                            <svg class="relative w-5 h-5 text-white group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Cart Items Container with custom scrollbar -->
                <div class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-800/50 backdrop-blur-sm transition-colors duration-300"
                     id="cart-items-container"
                     style="scrollbar-width: thin; scrollbar-color: #cbd5e0 #f7fafc;"
                     x-data="{ showEmpty: false }">

                    <!-- Loading State -->
                    <div id="cart-loading" class="flex flex-col items-center justify-center h-64">
                        <div class="relative">
                            <div class="w-16 h-16 border-4 border-gray-200 dark:border-gray-700 border-t-blue-600 dark:border-t-purple-600 rounded-full animate-spin"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-600 dark:to-pink-600 rounded-full animate-pulse"></div>
                            </div>
                        </div>
                        <p class="mt-4 text-gray-600 dark:text-gray-400 animate-pulse">Loading your cart...</p>
                    </div>

                    <!-- Cart Content -->
                    <div id="cart-content" class="space-y-4" style="display: none;">
                        <!-- Cart items will be loaded here -->
                    </div>

                    <!-- Empty Cart State -->
                    <div id="cart-empty" class="flex flex-col items-center justify-center h-64 text-center" style="display: none;">
                        <div class="relative mb-6">
                            <div class="w-24 h-24 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-gray-700 dark:to-gray-600 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-blue-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <div class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 dark:from-purple-500 dark:to-pink-500 rounded-full flex items-center justify-center text-white text-sm font-bold animate-bounce-subtle">
                                0
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Your cart is empty</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">Looks like you haven't added any items yet.</p>
                        <button onclick="toggleCart()" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-600 dark:to-pink-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 dark:hover:from-purple-700 dark:hover:to-pink-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Continue Shopping
                        </button>
                    </div>
                </div>

                <!-- Footer with checkout -->
                <div class="border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-6 py-6 space-y-4 transition-colors duration-300">
                    <!-- Coupon Code Section -->
                    <div class="flex space-x-2">
                        <div class="relative flex-1 group">
                            <input type="text" placeholder="Coupon code"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-purple-500 focus:border-transparent transition-all duration-200 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                            <div class="absolute inset-0 border-2 border-transparent group-hover:border-blue-500 dark:group-hover:border-purple-500 rounded-lg pointer-events-none transition-colors duration-200 opacity-0 group-hover:opacity-100"></div>
                        </div>
                        <button class="relative px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 font-medium overflow-hidden group">
                            <span class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 dark:from-purple-500 dark:to-pink-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                            <span class="relative">Apply</span>
                        </button>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                            <span>Subtotal</span>
                            <span id="cart-subtotal" class="font-medium text-gray-900 dark:text-white">$0.00</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                            <span>Shipping</span>
                            <span class="text-green-600 dark:text-green-400 font-medium">Free</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                            <span>Tax</span>
                            <span class="text-gray-500 dark:text-gray-500">Calculated at checkout</span>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
                            <div class="flex justify-between text-base font-bold">
                                <span class="text-gray-900 dark:text-white">Total</span>
                                <span id="cart-total" class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-400 dark:to-pink-400">$0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <a href="{{ route('marketplace.checkout') }}"
                       class="group relative flex justify-center items-center w-full px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-purple-600 dark:to-pink-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 overflow-hidden">
                        <span class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Proceed to Checkout
                    </a>

                    <!-- Continue Shopping Link -->
                    <div class="text-center">
                        <button onclick="toggleCart()" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-200 flex items-center justify-center mx-auto group">
                            <svg class="w-4 h-4 mr-1 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Continue Shopping
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<button onclick="toggleCart()" class="fixed bottom-6 right-6 group z-40">
    <div class="relative">
        <div class="absolute inset-0 bg-blue-600 rounded-full animate-ping opacity-20 group-hover:opacity-30"></div>
        <div class="relative bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-4 rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
        </div>
        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center shadow-lg animate-bounce-in">0</span>
    </div>
</button>

@push('styles')
    <!-- cart-drawer styles -->
    <style>
        /* Custom Scrollbar */
        #cart-items-container {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }

        #cart-items-container::-webkit-scrollbar {
            width: 6px;
        }

        #cart-items-container::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 10px;
        }

        #cart-items-container::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }

        #cart-items-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Dark mode scrollbar */
        .dark #cart-items-container {
            scrollbar-color: #4b5563 #1f2937;
        }

        .dark #cart-items-container::-webkit-scrollbar-track {
            background: #1f2937;
        }

        .dark #cart-items-container::-webkit-scrollbar-thumb {
            background: #4b5563;
        }

        .dark #cart-items-container::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }

        /* Animation Keyframes */
        @keyframes float-particle {
            0%, 100% { transform: translateY(0) translateX(0); opacity: 0.3; }
            25% { transform: translateY(-20px) translateX(10px); opacity: 0.6; }
            50% { transform: translateY(-30px) translateX(-10px); opacity: 0.4; }
            75% { transform: translateY(-20px) translateX(20px); opacity: 0.6; }
        }

        .animate-float-particle {
            animation: float-particle 6s ease-in-out infinite;
        }

        @keyframes pulse-slow {
            0%, 100% { opacity: 0.1; transform: scale(1); }
            50% { opacity: 0.2; transform: scale(1.1); }
        }

        .animate-pulse-slow {
            animation: pulse-slow 4s ease-in-out infinite;
        }

        @keyframes bounce-subtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .animate-bounce-subtle {
            animation: bounce-subtle 2s ease-in-out infinite;
        }

        /* Animation Delays */
        .animation-delay-1000 {
            animation-delay: 1s;
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease, color 0.3s ease;
        }
    </style>
@endpush

@push('scripts')
    <script>

        // Cart functionality

        const cartDrawer = document.getElementById('cart-drawer');
        const cartPanel = document.getElementById('cart-panel');

        function toggleCart() {
            if (!cartDrawer || !cartPanel) return;
            if (cartDrawer.style.display === 'none' || cartDrawer.style.display === '') {
                openCart();
            } else {
                closeCart();
            }
        }

        function openCart() {
            if (!cartDrawer || !cartPanel) return;
            cartDrawer.style.display = 'block';
            // Trigger reflow
            cartDrawer.offsetHeight;
            cartPanel.classList.remove('slide-out');
            cartPanel.classList.add('slide-in');
            loadCart();
            document.body.style.overflow = 'hidden';
        }

        function closeCart() {
            if (!cartDrawer || !cartPanel) return;
            cartPanel.classList.remove('slide-in');
            cartPanel.classList.add('slide-out');
            setTimeout(() => {
                cartDrawer.style.display = 'none';
                document.body.style.overflow = '';
            }, 500);
        }

        // Load cart data
        async function loadCart() {
            try {
                const loading = document.getElementById('cart-loading');
                const content = document.getElementById('cart-content');
                const empty = document.getElementById('cart-empty');

                loading.style.display = 'flex';
                content.style.display = 'none';
                empty.style.display = 'none';

                fetch('{{ route("marketplace.cart") }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loading.style.display = 'none';
                            if (data.cart_items && data.cart_items.length > 0) {
                                content.style.display = 'block';
                                renderCartItems(data);
                            } else {
                                empty.style.display = 'flex';
                            }
                            // Update cart display (use your existing updateCartDisplay function)
                            if (typeof updateCartDisplay === 'function') {
                                updateCartDisplay(data);
                            }
                        }
                    });
            } catch (error) {
                console.error('Error loading cart:', error);
            }
        }

        function renderCartItems(data) {
            const container = document.getElementById('cart-content');
            let html = '';

            data.cart_items.forEach(item => {
                html += `
                <div class="flex items-center space-x-4 p-4 bg-white dark:bg-gray-700/50 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 group/item">
                    <div class="relative w-20 h-20 flex-shrink-0 overflow-hidden rounded-lg">
                        <img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover group-hover/item:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover/item:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate">${item.name}</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">${item.price}</p>
                            </div>
                            <button onclick="removeFromCart(${item.id})" class="p-1 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-full transition-colors duration-200">
                                <svg class="w-4 h-4 text-gray-400 hover:text-red-500 dark:hover:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center border border-gray-200 dark:border-gray-600 rounded-lg">
                                <button onclick="updateQuantity(${item.id}, 'decrease')" class="px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <svg class="w-3 h-3 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                    </svg>
                                </button>
                                <span class="px-3 py-1 text-sm font-medium text-gray-900 dark:text-white border-x border-gray-200 dark:border-gray-600">${item.quantity}</span>
                                <button onclick="updateQuantity(${item.id}, 'increase')" class="px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <svg class="w-3 h-3 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">$${(item.price * item.quantity).toFixed(2)}</span>
                        </div>
                    </div>
                </div>
            `;
            });

            container.innerHTML = html;
        }

        function updateCartTotals(data) {
            document.getElementById('cart-item-count').textContent = `${data.totalItems} items`;
            document.getElementById('cart-subtotal').textContent = `$${data.subtotal.toFixed(2)}`;
            document.getElementById('cart-total').textContent = `$${data.total.toFixed(2)}`;
        }

        // Initialize cart on page load
        document.addEventListener('DOMContentLoaded', () => {
            loadCart();

            // Close cart on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    const drawer = document.getElementById('cart-drawer');
                    if (drawer.style.display === 'block') {
                        toggleCart();
                    }
                }
            });
        });

        function generateSkeletonLoader() {
            let skeleton = '';
            for (let i = 0; i < 3; i++) {
                skeleton += `
            <div class="flex py-6">
                <div class="flex-shrink-0 w-24 h-24 skeleton rounded-lg"></div>
                <div class="ml-4 flex-1 space-y-3">
                    <div class="h-4 skeleton rounded w-3/4"></div>
                    <div class="h-3 skeleton rounded w-1/2"></div>
                    <div class="h-8 skeleton rounded w-full"></div>
                </div>
            </div>
        `;
            }
            return skeleton;
        }

        function updateCartDisplay(data) {
            const cartContent = document.getElementById('cart-content');
            const cartSubtotal = document.getElementById('cart-subtotal');
            const cartTotal = document.getElementById('cart-total');
            const cartItemCount = document.getElementById('cart-item-count');

            if (data.cart_items && data.cart_items.length > 0) {
                const totalItems = data.cart_items.reduce((sum, item) => sum + item.quantity, 0);
                cartItemCount.textContent = `${totalItems} ${totalItems === 1 ? 'item' : 'items'}`;

                let html = '<div class="flow-root"><ul class="m-2">';

                data.cart_items.forEach(item => {
                    const itemTotal = (item.quantity * parseFloat(item.price)).toFixed(2);
                    html += `
                <li class="cart-item my-4 bg-white dark:bg-gray-700/50 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 group/item" data-item-id="${item.id}">
                    <div class="flex">
                        <!-- Product Image -->
                        <div class="flex-shrink-0 w-32 h-32 rounded-lg overflow-hidden shadow-sm">
                            ${item.product.images && item.product.images[0] ?
                        `<img src="${item.product.images[0]}" alt="${item.product.name}" class="w-full h-full object-center object-cover">` :
                        `<div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>`
                    }
                        </div>

                        <!-- Product Details -->
                        <div class="ml-4 flex-1 flex flex-col p-3">
                            <div class="flex justify-between">
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 hover:text-blue-600 transition-colors">
                                        <a href="{{ url('/marketplace/cart/add') }} /${item.product.id}">${item.product.name}</a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-100">${item.team?.name}</p>
                                </div>
                                <p class="text-base font-bold text-gray-900 dark:text-gray-50">$${itemTotal}</p>
                            </div>

                            <!-- Quantity and Remove -->
                            <div class="flex-1 flex items-end justify-between mt-2">
                                <div class="flex items-center space-x-2">
                                    <label class="text-sm text-gray-500">Qty:</label>
                                    <div class="relative">
                                        <select onchange="updateCartItem(${item.product.id}, this.value)"
                                                class="appearance-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 px-3 py-2">
                                            ${[1,2,3,4,5,6,7,8,9,10].map(num =>
                        `<option value="${num}" ${item.quantity == num ? 'selected' : ''}>${num}</option>`
                    ).join('')}
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <button onclick="removeItemFromCart(${item.product.id})"
                                        class="text-sm text-red-600 hover:cursor-pointer hover:text-red-800 font-medium flex items-center transition-colors duration-200 group">
                                    <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
            `;
                });

                html += '</ul></div>';
                cartContent.innerHTML = html;
                cartSubtotal.textContent = `$${parseFloat(data.total_amount).toFixed(2)}`;
                cartTotal.textContent = `$${parseFloat(data.total_amount).toFixed(2)}`;
            } else {
                // Empty cart state with illustration
                cartContent.innerHTML = `
            <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                <div class="w-32 h-32 mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-sm text-gray-500 mb-6">Looks like you haven't added any items to your cart yet.</p>
                <button onclick="toggleCart()" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Start Shopping
                </button>
            </div>
        `;
                cartItemCount.textContent = '0 items';
                cartSubtotal.textContent = '$0.00';
                cartTotal.textContent = '$0.00';
            }
        }

        function updateCartItem(productId, quantity) {
            // Show loading state
            const selectElement = event.currentTarget;
            const originalDisabled = selectElement.disabled;
            selectElement.disabled = true;
            selectElement.classList.add('opacity-50');

            // Make API call to update cart
            fetch(`{{ url('/marketplace/cart/update') }}/${productId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    quantity: parseInt(quantity),
                    _method: 'PUT' // Laravel method spoofing
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update cart display with new data
                        updateCartDisplay(data);

                        // Show success notification
                        showNotification('Cart updated successfully!', 'success');

                        // Update cart count in header
                        updateCartCount();
                    } else {
                        // Show error notification
                        showNotification(data.message || 'Failed to update cart', 'error');

                        // Reload cart to show correct state
                        loadCart();
                    }
                })
                .catch(error => {
                    console.error('Cart update error:', error);
                    showNotification('An error occurred while updating cart', 'error');

                    // Reload cart to show correct state
                    loadCart();
                })
                .finally(() => {
                    // Remove loading state
                    selectElement.disabled = originalDisabled;
                    selectElement.classList.remove('opacity-50');
                });
        }

        function removeItemFromCart(productId) {
            if (confirm('Are you sure you want to remove this item from your cart?')) {
                fetch(`/marketplace/cart/remove/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Item removed from cart', 'success');
                            updateCartCount();
                            loadCart(); // Reload cart to show updated items
                        } else {
                            showNotification(data.message || 'Failed to remove item from cart', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('An error occurred while removing the item', 'error');
                    });
            }
        }

        // Close cart on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && cartDrawer.style.display === 'block') {
                closeCart();
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();

            // Ensure cart drawer starts hidden with correct transform
            if (cartDrawer) {
                cartDrawer.style.display = 'none';
            }
            if (cartPanel) {
                cartPanel.classList.add('slide-out');
            }
        });
    </script>
@endpush
