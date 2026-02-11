<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

<style>

    /* Custom scrollbar for prompt content */
    .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

</style>

<div class="flex flex-col h-[75vh] bg-white dark:bg-gray-900 rounded-xl shadow overflow-hidden">


    <div class="max-w-4xl w-full text-center mb-10 animate-fade-in">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">Awesome Responsive Prompt Box</h1>
        <p class="text-gray-600 text-lg">Click the button below to open a responsive prompt box that works perfectly on all devices</p>
    </div>

    <!-- Demo trigger button -->
    <button id="openPromptBtn" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 text-lg mb-16 animate-bounce-subtle">
        <i class="fas fa-comment-alt mr-2"></i> Open Prompt Box
    </button>

    <!-- Prompt Box Overlay -->
    <div id="promptOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden items-center justify-center p-4">
        <!-- Prompt Box Container -->
        <div id="promptBox" class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden transform transition-all duration-300 scale-95 opacity-0 max-h-[90vh] flex flex-col">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-white bg-opacity-20 p-3 rounded-xl mr-4">
                            <i class="fas fa-exclamation-circle text-xl"></i>
                        </div>
                        <div class="text-left">
                            <h2 class="text-xl font-bold">Action Required</h2>
                            <p class="text-blue-100 text-sm mt-1">Please confirm your choice</p>
                        </div>
                    </div>
                    <button id="closePromptBtn" class="text-white hover:bg-white hover:bg-opacity-20 p-2 rounded-full transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6 flex-grow overflow-y-auto custom-scrollbar">
                <div class="mb-6">
                    <div class="flex items-center justify-center mb-4">
                        <div class="bg-yellow-50 p-4 rounded-full">
                            <i class="fas fa-question-circle text-3xl text-yellow-500"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Are you sure you want to proceed?</h3>
                    <p class="text-gray-600 mb-4">This action cannot be undone. It will permanently delete your data and remove all associated content from our servers.</p>

                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-700 font-medium">Please type <span class="text-red-500 font-bold">"CONFIRM"</span> in the box below to proceed with this action.</p>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="confirmInput" class="block text-left text-gray-700 font-medium mb-2">Confirmation Text</label>
                    <div class="relative">
                        <input type="text" id="confirmInput" placeholder="Type CONFIRM here" class="w-full p-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <i id="inputIcon" class="fas fa-exclamation text-gray-400"></i>
                        </div>
                    </div>
                    <div id="inputError" class="text-red-500 text-sm mt-2 text-left hidden">
                        <i class="fas fa-exclamation-circle mr-1"></i> Text does not match. Please type "CONFIRM" exactly.
                    </div>
                </div>

                <!-- Additional options for demonstration -->
                <div class="mb-6">
                    <p class="text-gray-700 font-medium text-left mb-3">Additional options:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" id="option1" class="mr-3 h-5 w-5 text-blue-600">
                            <label for="option1" class="text-gray-700">Send notification</label>
                        </div>
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" id="option2" class="mr-3 h-5 w-5 text-blue-600">
                            <label for="option2" class="text-gray-700">Keep backup</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="border-t border-gray-200 p-6 bg-gray-50">
                <div class="flex flex-col sm:flex-row gap-3 justify-end">
                    <button id="cancelBtn" class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-100 transition-colors w-full sm:w-auto">
                        Cancel
                    </button>
                    <button id="confirmBtn" class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-medium rounded-xl hover:from-red-600 hover:to-red-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all shadow-md hover:shadow-lg w-full sm:w-auto">
                        Confirm Action
                    </button>
                </div>
                <p class="text-xs text-gray-500 text-center mt-4">
                    <i class="fas fa-info-circle mr-1"></i> This prompt is fully responsive and works on all devices
                </p>
            </div>
        </div>
    </div>

    <!-- Device preview bar (for demonstration) -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-3 flex items-center justify-center space-x-4 shadow-lg">
        <p class="text-gray-700 font-medium hidden md:block">Try resizing your browser to see responsiveness</p>
        <div class="flex items-center space-x-2">
            <div class="flex items-center bg-gray-100 px-3 py-1 rounded-lg">
                <i class="fas fa-mobile-alt text-gray-600 mr-2"></i>
                <span class="text-gray-700">Mobile</span>
            </div>
            <div class="flex items-center bg-gray-100 px-3 py-1 rounded-lg">
                <i class="fas fa-tablet-alt text-gray-600 mr-2"></i>
                <span class="text-gray-700">Tablet</span>
            </div>
            <div class="flex items-center bg-gray-100 px-3 py-1 rounded-lg">
                <i class="fas fa-desktop text-gray-600 mr-2"></i>
                <span class="text-gray-700">Desktop</span>
            </div>
        </div>
    </div>

</div>

<script>
    // Get DOM elements
    const openPromptBtn = document.getElementById('openPromptBtn');
        const closePromptBtn = document.getElementById('closePromptBtn');
        const promptOverlay = document.getElementById('promptOverlay');
        const promptBox = document.getElementById('promptBox');
        const cancelBtn = document.getElementById('cancelBtn');
        const confirmBtn = document.getElementById('confirmBtn');
        const confirmInput = document.getElementById('confirmInput');
        const inputError = document.getElementById('inputError');
        const inputIcon = document.getElementById('inputIcon');

        // Open prompt box
        openPromptBtn.addEventListener('click', () => {
            promptOverlay.classList.remove('hidden');
            promptOverlay.classList.add('flex');

            // Trigger animation
            setTimeout(() => {
                promptBox.classList.remove('scale-95', 'opacity-0');
                promptBox.classList.add('scale-100', 'opacity-100');
            }, 10);

            // Reset input and button states
            confirmInput.value = '';
            confirmBtn.disabled = true;
            inputError.classList.add('hidden');
            inputIcon.className = 'fas fa-exclamation text-gray-400';
        });

        // Close prompt box
        const closePrompt = () => {
            promptBox.classList.remove('scale-100', 'opacity-100');
            promptBox.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                promptOverlay.classList.remove('flex');
                promptOverlay.classList.add('hidden');
            }, 300);
        };

        closePromptBtn.addEventListener('click', closePrompt);
        cancelBtn.addEventListener('click', closePrompt);

        // Close when clicking outside the prompt box
        promptOverlay.addEventListener('click', (e) => {
            if (e.target === promptOverlay) {
                closePrompt();
            }
        });

        // Validate input
        confirmInput.addEventListener('input', () => {
            const inputValue = confirmInput.value.trim();

            if (inputValue === 'CONFIRM') {
                confirmBtn.disabled = false;
                inputError.classList.add('hidden');
                inputIcon.className = 'fas fa-check text-green-500';
                confirmInput.classList.remove('border-red-500');
                confirmInput.classList.add('border-green-500');
            } else if (inputValue.length > 0) {
                confirmBtn.disabled = true;
                inputError.classList.remove('hidden');
                inputIcon.className = 'fas fa-times text-red-500';
                confirmInput.classList.remove('border-green-500');
                confirmInput.classList.add('border-red-500');
            } else {
                confirmBtn.disabled = true;
                inputError.classList.add('hidden');
                inputIcon.className = 'fas fa-exclamation text-gray-400';
                confirmInput.classList.remove('border-green-500', 'border-red-500');
            }
        });

        // Confirm action
        confirmBtn.addEventListener('click', () => {
            if (confirmInput.value.trim() === 'CONFIRM') {
                // Show success animation
                confirmBtn.innerHTML = '<i class="fas fa-check mr-2"></i> Action Confirmed!';
                confirmBtn.classList.remove('from-red-500', 'to-red-600', 'hover:from-red-600', 'hover:to-red-700');
                confirmBtn.classList.add('from-green-500', 'to-green-600', 'hover:from-green-600', 'hover:to-green-700');

                // Close after delay
                setTimeout(() => {
                    closePrompt();

                    // Reset button after a moment
                    setTimeout(() => {
                        confirmBtn.innerHTML = 'Confirm Action';
                        confirmBtn.classList.remove('from-green-500', 'to-green-600', 'hover:from-green-600', 'hover:to-green-700');
                        confirmBtn.classList.add('from-red-500', 'to-red-600', 'hover:from-red-600', 'hover:to-red-700');
                    }, 500);
                }, 1500);
            }
        });

        // Add keyboard support
        document.addEventListener('keydown', (e) => {
            // Close on Escape key
            if (e.key === 'Escape' && !promptOverlay.classList.contains('hidden')) {
                closePrompt();
            }

            // Submit on Enter when input is focused and valid
            if (e.key === 'Enter' && document.activeElement === confirmInput && confirmInput.value.trim() === 'CONFIRM') {
                confirmBtn.click();
            }
        });
</script>


 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php /**PATH E:\Extra\Laravel\Laravel-Filament-Starter-Kit\resources\views/filament/tenant/pages/prompt-action.blade.php ENDPATH**/ ?>