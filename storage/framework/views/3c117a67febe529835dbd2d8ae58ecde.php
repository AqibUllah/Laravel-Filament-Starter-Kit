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
    .typing-indicator {
        display: inline-block;
        position: relative;
        width: 60px;
        height: 10px;
    }
    .typing-indicator span {
        position: absolute;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #9ca3af;
        animation: typing 1.4s infinite ease-in-out;
    }
    .typing-indicator span:nth-child(1) {
        left: 0;
        animation-delay: 0s;
    }
    .typing-indicator span:nth-child(2) {
        left: 15px;
        animation-delay: 0.2s;
    }
    .typing-indicator span:nth-child(3) {
        left: 30px;
        animation-delay: 0.4s;
    }
    @keyframes typing {
        0%, 60%, 100% {
            transform: translateY(0);
            opacity: 0.5;
        }
        30% {
            transform: translateY(-10px);
            opacity: 1;
        }
    }

    #chat-container {
        scroll-behavior: smooth;
    }


</style>

<div class="flex flex-col h-[75vh] bg-white dark:bg-gray-900 rounded-xl shadow overflow-hidden">

    <!-- Chat Messages -->
    <div id="chat-container"
         class="flex-1 overflow-y-auto p-6 space-y-4">

        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <!-- User Message -->
            <!--[if BLOCK]><![endif]--><?php if($chat->role->value == 'user'): ?>
            <div class="flex justify-end">
                <div class="bg-primary-600 text-white px-4 py-2 rounded-2xl max-w-lg">
                        <?php echo e($chat->content); ?>

                    </div>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <!-- AI Response -->
            <!--[if BLOCK]><![endif]--><?php if($chat->role->value == 'assistant'): ?>
                <div class="flex justify-start">
                    <div class="bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white px-4 py-2 rounded-2xl max-w-lg">
                        <?php echo e($chat->content); ?>

                    </div>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

        <div wire:loading wire:target="send" class="flex justify-start">
            <div class="bg-neutral-100 dark:bg-neutral-800 pl-3 py-3">
                <div class="typing-indicator">
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
            </div>
        </div>

    </div>

    <div class="border-t border-gray-200 dark:border-white/10 bg-white dark:bg-gray-900 p-4 sticky bottom-0">
        <div class="max-w-4xl mx-auto">
            <form wire:submit.prevent="send" class="relative flex items-end gap-2 shadow-sm border border-gray-300 dark:border-gray-600 rounded-2xl bg-gray-50 dark:bg-gray-800 focus-within:ring-1 focus-within:ring-primary-500 transition-all p-2">

                <textarea
                    wire:model.defer="message"
                    placeholder="Message..."
                    rows="1"
                    oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"
                    class="block w-full border-0 bg-transparent py-3 pl-3 pr-12 outline-none focus:ring-0 text-gray-900 dark:text-white placeholder:text-gray-400 sm:text-sm sm:leading-6 resize-none"
                    style="min-height: 44px; max-height: 300px;"
                ></textarea>

                <div class="flex items-center pr-2 pb-1">
                    <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['type' => 'submit','size' => 'sm','color' => 'primary','class' => 'rounded-lg']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','size' => 'sm','color' => 'primary','class' => 'rounded-lg']); ?>
                        <?php if (isset($component)) { $__componentOriginalbef7c2371a870b1887ec3741fe311a10 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbef7c2371a870b1887ec3741fe311a10 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.loading-indicator','data' => ['wire:loading' => true,'wire:target' => 'send','class' => 'h-5 w-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::loading-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:loading' => true,'wire:target' => 'send','class' => 'h-5 w-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbef7c2371a870b1887ec3741fe311a10)): ?>
<?php $attributes = $__attributesOriginalbef7c2371a870b1887ec3741fe311a10; ?>
<?php unset($__attributesOriginalbef7c2371a870b1887ec3741fe311a10); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbef7c2371a870b1887ec3741fe311a10)): ?>
<?php $component = $__componentOriginalbef7c2371a870b1887ec3741fe311a10; ?>
<?php unset($__componentOriginalbef7c2371a870b1887ec3741fe311a10); ?>
<?php endif; ?>

                        <span wire:loading.remove wire:target="send">
                            <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => 'heroicon-m-paper-airplane','class' => 'h-5 w-5 rotate-[-45deg]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heroicon-m-paper-airplane','class' => 'h-5 w-5 rotate-[-45deg]']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $attributes = $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $component = $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
                        </span>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
                </div>
            </form>

            <p class="mt-2 text-center text-[10px] text-gray-500">
                Press Enter to send. AI can make mistakes.
            </p>
        </div>
    </div>


</div>

<script>
    document.addEventListener('livewire:load', function () {
        const container = document.getElementById('chat-container');
        container.scrollTop = container.scrollHeight;
    });

    document.addEventListener('livewire:update', function () {
        const container = document.getElementById('chat-container');
        container.scrollTop = container.scrollHeight;
    });

    document.addEventListener('livewire:init', () => {
        Livewire.on('scrollToBottom', () => {
            const container = document.getElementById('chat-container');

            console.log(container)
            if (!container) return;


            container.scrollTo({
                top: container.scrollHeight + 100,
                behavior: 'smooth'
            });
        });
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
<?php /**PATH E:\Extra\Laravel\Laravel-Filament-Starter-Kit\resources\views/filament/tenant/pages/support-chat.blade.php ENDPATH**/ ?>