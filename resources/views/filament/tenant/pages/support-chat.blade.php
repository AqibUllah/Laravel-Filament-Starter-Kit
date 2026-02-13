<x-filament-panels::page>

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
        /* Use 80% of the dynamic viewport height, or whatever fits your UI */
        height: 80dvh;

        /* Ensures it doesn't get ridiculously small on tiny phones */
        min-height: 300px;

        /* Standard styling */
        scroll-behavior: smooth;
        overflow-y: auto;
    }


</style>

<div class="flex flex-col h-[75vh] bg-white dark:bg-gray-900 rounded-xl shadow overflow-hidden">

    <!-- Chat Messages -->
    <div id="chat-container"
         class="flex-1 overflow-y-auto p-6 space-y-4">

        @foreach ($this->messages as $chat)

            <!-- User Message -->
            @if ($chat->role->value == 'user')
                <div class="flex justify-end">
                    <div class="bg-primary-600 text-white px-4 py-2 rounded-2xl max-w-lg">
                            {{ $chat->content }}
                    </div>
                </div>
            @else
                <div class="flex justify-start">
                    <div class="prose bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white px-4 py-2 rounded-2xl max-w-5xl">
                        {!! $chat->content !!}
                    </div>
                </div>
            @endif

        @endforeach

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

    <div class="bg-white dark:bg-gray-900 sticky bottom-0">
        <div class="max-w-full mx-auto">
            <form wire:submit.prevent="send" class="relative flex items-end gap-2 shadow-sm rounded-tl-none rounded-tr-none border border-gray-300 dark:border-gray-800 rounded-xl bg-gray-50 dark:bg-gray-800 focus-within:ring-1 focus-within:ring-primary-500 transition-all p-1">

                <textarea
                    wire:model.defer="message"
                    placeholder="Message..."
                    rows="1"
                    oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"
                    class="block w-full border-0 bg-transparent py-3 pl-3 pr-12 outline-none focus:ring-0 text-gray-900 dark:text-white placeholder:text-gray-400 sm:text-sm sm:leading-6 resize-none"
                    style="min-height: 44px; max-height: 300px;"
                ></textarea>

                <div class="flex items-center pr-2 pb-1">
                    <x-filament::button
                        type="submit"
                        size="lg"
                        color="primary"
                        class="rounded-lg"
                    >
                        <x-filament::loading-indicator wire:loading wire:target="send" class="h-5 w-5" />

                        <span wire:loading.remove wire:target="send">
                            <x-filament::icon
                                icon="heroicon-m-paper-airplane"
                                class="h-5 w-5 rotate-[-45deg]"
                            />
                        </span>
                    </x-filament::button>
                </div>
            </form>
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

            if (!container) return;


            container.scrollTo({
                top: container.scrollHeight + 100,
                behavior: 'smooth'
            });
        });
    });
</script>


</x-filament-panels::page>
