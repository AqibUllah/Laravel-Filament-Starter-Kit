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
            height: 70dvh;
            min-height: 300px;
            scroll-behavior: smooth;
            overflow-y: auto;
        }

        /* Modern dropdown styling */
        .mode-selector {
            position: relative;
            min-width: 200px;
        }

        .mode-selector select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: transparent;
            padding: 0.5rem 2rem 0.5rem 1rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            cursor: pointer;
            width: 100%;
            color: #374151;
            transition: all 0.2s;
            font-weight: 500;
        }

        .dark .mode-selector select {
            border-color: #374151;
            color: #e5e7eb;
            background-color: #1f2937;
        }

        .mode-selector select:hover {
            border-color: #6366f1;
        }

        .mode-selector select:focus {
            outline: none;
            border-color: #6366f1;
            ring: 2px solid rgba(99, 102, 241, 0.2);
        }

        .mode-selector::after {
            content: '';
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1rem;
            height: 1rem;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5' /%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
            pointer-events: none;
        }

        .dark .mode-selector::after {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='%239ca3af'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5' /%3E%3C/svg%3E");
        }

        .mode-selector:hover::after {
            stroke: #6366f1;
        }

        /* Option styling */
        .mode-selector select option {
            padding: 0.5rem;
            background-color: white;
            color: #374151;
        }

        .dark .mode-selector select option {
            background-color: #1f2937;
            color: #e5e7eb;
        }

        /* Mode badge styling */
        .mode-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            background-color: #f3f4f6;
            color: #4b5563;
        }

        .dark .mode-badge {
            background-color: #374151;
            color: #9ca3af;
        }

        /* Message bubbles */
        .message-bubble {
            max-width: 80%;
            word-wrap: break-word;
        }

        /* Custom scrollbar */
        #chat-container::-webkit-scrollbar {
            width: 6px;
        }

        #chat-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #chat-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        #chat-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .dark #chat-container::-webkit-scrollbar-track {
            background: #2d2d2d;
        }

        .dark #chat-container::-webkit-scrollbar-thumb {
            background: #555;
        }

        .dark #chat-container::-webkit-scrollbar-thumb:hover {
            background: #666;
        }
    </style>

    <div class="flex flex-col h-[calc(100vh-10rem)] bg-white dark:bg-gray-900 rounded-xl shadow overflow-hidden">

        <!-- Header with Mode Selector -->
        <div class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="flex items-center space-x-2">
                    <x-filament::icon
                        icon="heroicon-o-chat-bubble-left-right"
                        class="h-5 w-5 text-primary-600 dark:text-primary-400"
                    />
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Support Chat</h2>
                </div>
                <span class="text-sm text-gray-500 dark:text-gray-400">|</span>
{{--                <div class="mode-selector">--}}
{{--                    <select wire:model.live="selectedMode" wire:change="changeMode($event.target.value)">--}}
{{--                        <option value="chat">💬 General Chat</option>--}}
{{--                        <option value="audio">🎨 Text to Audio</option>--}}
{{--                        <option value="image">🎨 Image Generation</option>--}}
{{--                        <option value="content">✍️ Content Writing</option>--}}
{{--                        <option value="research">🔬 Research Assistant</option>--}}
{{--                        <option value="code">💻 Code Helper</option>--}}
{{--                        <option value="translate">🌍 Translation</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
            </div>

            <!-- Current mode indicator -->
            <div class="flex items-center space-x-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
            </span>
                <span class="mode-badge">
                @switch($selectedMode)
                        @case('image')
                            🎨 Image Mode
                            @break
                        @case('audio')
                            ✍️ Audio Mode
                            @break
                        @case('research')
                            🔬 Research Mode
                            @break
                        @case('code')
                            💻 Code Mode
                            @break
                        @case('translate')
                            🌍 Translation Mode
                            @break
                        @default
                            💬 Chat Mode
                    @endswitch
            </span>
            </div>
        </div>

        <!-- Chat Messages -->
        <div id="chat-container"
             class="flex-1 overflow-y-auto p-6 space-y-4"
             x-data
             x-init="$nextTick(() => { $el.scrollTop = $el.scrollHeight; })"
             @scroll-to-bottom.window="$nextTick(() => { $el.scrollTo({ top: $el.scrollHeight, behavior: 'smooth' }); })">

            @forelse ($this->messages as $chat)
                <!-- User Message -->
                @if ($chat->role->value == 'user')
                    <div class="flex justify-end">
                        <div class="message-bubble bg-primary-600 text-white px-4 py-2 rounded-2xl rounded-br-none">
                            <div class="text-sm">
                                {{ $chat->content }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex justify-start">
                        <div class="message-bubble bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white px-4 py-2 rounded-2xl rounded-bl-none">
                            <div class="prose dark:prose-invert max-w-none text-sm">
                                {!! $chat->content !!}
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <!-- Welcome message -->
                <div class="flex flex-col items-center justify-center h-full text-center text-gray-500 dark:text-gray-400">
                    <x-filament::icon
                        icon="heroicon-o-chat-bubble-left-right"
                        class="h-12 w-12 mx-auto mb-3 text-gray-400 dark:text-gray-600"
                    />
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Welcome to Support Chat</h3>
                    <p class="text-sm max-w-md">
                        @switch($selectedMode)
                            @case('image')
                                Describe the image you want to generate, and I'll create it for you.
                                @break
                            @case('audio')
                                Tell me what you'd like me to transform into audio.
                                @break
                            @case('research')
                                Ask me anything, and I'll research it for you.
                                @break
                            @case('code')
                                Need help with code? Just ask!
                                @break
                            @case('translate')
                                What would you like me to translate?
                                @break
                            @default
                                How can I help you today?
                        @endswitch
                    </p>
                </div>
            @endforelse

            <!-- Typing indicator -->
            <div wire:loading wire:target="send" class="flex justify-start">
                <div class="bg-gray-100 dark:bg-gray-800 px-4 py-3 rounded-2xl rounded-bl-none">
                    <div class="typing-indicator">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Input Area -->
        <div class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 p-4">
            <div class="max-w-full mx-auto">
                <form wire:submit.prevent="send" class="relative">
                    <div class="flex items-end gap-2">
                        <div class="flex-1 relative">
                        <textarea
                            wire:model.defer="message"
                            x-data="{
                                resize: () => {
                                    $el.style.height = 'auto';
                                    $el.style.height = $el.scrollHeight + 'px';
                                }
                            }"
                            x-init="resize"
                            @input="resize"
                            placeholder="{{ match($selectedMode) {
                                'image' => 'Describe the image you want to generate...',
                                'audio' => 'What would you like me to transform into audio?',
                                'research' => 'What would you like me to research?',
                                'code' => 'Describe the code you need help with...',
                                'translate' => 'Enter text to translate...',
                                default => 'Type your message here...'
                            } }}"
                            rows="1"
                            class="block w-full border border-gray-300 dark:border-gray-700 rounded-xl bg-white dark:bg-gray-800 py-3 px-4 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-primary-500 focus:border-transparent resize-none overflow-hidden"
                            style="min-height: 44px; max-height: 200px;"
                        ></textarea>

                            <!-- Character count (optional) -->
                            <div class="absolute right-3 bottom-3 text-xs text-gray-400 dark:text-gray-500">
                                {{ strlen($message ?? '') }}/2000
                            </div>
                        </div>

                        <div class="flex-shrink-0">
                            <x-filament::button
                                type="submit"
                                size="lg"
                                color="primary"
                                class="rounded-xl h-11 w-11 p-0 flex items-center justify-center"
                                :disabled="blank($message)"
                            >
                                <x-filament::loading-indicator
                                    wire:loading
                                    wire:target="send"
                                    class="h-5 w-5"
                                />
                                <span wire:loading.remove wire:target="send">
                                <x-filament::icon
                                    icon="heroicon-m-paper-airplane"
                                    class="h-5 w-5"
                                />
                            </span>
                            </x-filament::button>
                        </div>
                    </div>
                </form>

                <!-- Mode-specific tips -->
                <div class="mt-2 text-xs text-gray-500 dark:text-gray-400 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <x-filament::icon
                            icon="heroicon-m-light-bulb"
                            class="h-4 w-4 text-amber-500"
                        />
                        <span>
                        @switch($selectedMode)
                                @case('image')
                                    Be descriptive about style, colors, composition, and subject matter
                                    @break
                                @case('audio')
                                    Specify voice tone (e.g., calm, energetic, professional), speaking speed, accent, emotion, and approximate length in seconds or minutes
                                    @break
                                @case('research')
                                    Ask specific questions or request summaries of complex topics
                                    @break
                                @case('code')
                                    Mention programming language and what you're trying to achieve
                                    @break
                                @case('translate')
                                    Specify source and target languages (e.g., "Translate to Spanish:")
                                    @break
                                @default
                                    Press Enter to send, Shift+Enter for new line
                            @endswitch
                    </span>
                    </div>

                    <!-- Keyboard shortcut hint -->
                    <span class="text-gray-400 dark:text-gray-500">
                    ⌘ + Enter
                </span>
                </div>
            </div>
        </div>

    </div>

    <!-- Scroll to bottom on new message -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('scrollToBottom', () => {
                const container = document.getElementById('chat-container');
                if (container) {
                    setTimeout(() => {
                        container.scrollTo({
                            top: container.scrollHeight,
                            behavior: 'smooth'
                        });
                    }, 100);
                }
            });
        });

        // Auto-scroll on page load
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('chat-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });

        // Handle Enter key for form submission (with Shift+Enter for new line)
        document.addEventListener('keydown', (e) => {
            if (e.target.tagName === 'TEXTAREA' && e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (!e.target.disabled && e.target.value.trim() !== '') {
                    e.target.form?.requestSubmit();
                }
            }
        });
    </script>

</x-filament-panels::page>
