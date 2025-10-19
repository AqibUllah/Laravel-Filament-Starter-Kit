<x-filament-panels::page style="margin-bottom: 500px">
    <form wire:submit="save">
        {{ $this->form }}
        <x-filament::button
            type="submit"
            color="info"
            class="mt-10"
            icon="heroicon-m-sparkles">
            Save
        </x-filament::button>
    </form>

    <x-filament::section>
        <x-slot name="heading">Team Members</x-slot>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($team->members as $member)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <!-- Header with background -->
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-4"></div>

                    <!-- Member Content -->
                    <div class="p-6">
                        <!-- Avatar and Basic Info -->
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="relative">
                                <img
                                    src="{{ $member->avatar ? asset('storage/' . $member->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($member->name) . '&background=3B82F6&color=ffffff' }}"
                                    alt="{{ $member->name }}"
                                    class="w-16 h-16 rounded-full border-4 border-white dark:border-sky-400 shadow-md"
                                >
                                @if($member->is_active)
                                    <div class="absolute bottom-1 right-0 w-4 h-4 bg-green-500 rounded-full border-2 border-white dark:border-green-600"></div>
                                @else
                                    <div class="absolute bottom-1 right-0 w-4 h-4 bg-gray-400 dark:bg-gray-700 rounded-full border-2 border-white dark:border-gray-600"></div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-300 truncate">{{ $member->name }}</h3>
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="truncate">{{ $member->email }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="space-y-2 mb-4">
                            @if($member->phone)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $member->phone }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Bio -->
                        @if($member->bio)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 line-clamp-3">{{ $member->bio }}</p>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="flex justify-between items-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $member->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-400' }}">
                            {{ $member->is_active ? 'Active' : 'Inactive' }}
                        </span>

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <a href="mailto:{{ $member->email }}" class="text-gray-400 hover:text-blue-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if($team->members->count() === 0)
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No team members</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by adding members to this team.</p>
            </div>
        @endif
    </x-filament::section>
{{--    {{ $this->table }}--}}
</x-filament-panels::page>
<script>
    document.addEventListener('livewire:init', function () {
        // Livewire.on('companyProfileUpdated', function () {
        //     window.location.reload();
        // });
    });
</script>
