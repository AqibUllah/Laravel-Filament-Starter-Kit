<x-filament-panels::page>
    @php
        $settings = app(\App\Settings\TenantGeneralSettings::class)
    @endphp

    <div class="space-y-8">

        <!-- Settings Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Branding Card -->
            <x-filament::section class="h-full">
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-paint-brush class="w-5 h-5 text-primary-500 mr-2" />
                        <span>Branding</span>
                    </div>
                </x-slot>
                <x-slot name="description" class="mt-1">
                    Customize your company identity and visual appearance
                </x-slot>

                <div class="space-y-4">
                    <div class="flex items-start justify-between py-2">
                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300">Brand Name</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $settings->company_name ?? 'Not set' }}</p>
                        </div>
                        <x-heroicon-o-building-office class="w-5 h-5 text-gray-400" />
                    </div>

                    <div class="flex items-start justify-between py-2">
                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300">Brand Logo</p>
                            @if(!empty($settings->company_logo_path))
                                <div class="mt-2">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($settings->company_logo_path) }}" alt="Company Logo" class="h-8 rounded-md shadow-sm" />
                                </div>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">No logo uploaded</p>
                            @endif
                        </div>
                        <x-heroicon-o-photo class="w-5 h-5 text-gray-400" />
                    </div>

                    <div class="flex items-start justify-between py-2">
                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300">Primary Color</p>
                            @if(!empty($settings->primary_color))
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="inline-block h-4 w-8 rounded border border-gray-200" style="background-color: {{ $settings->primary_color }}"></span>
                                    <span class="text-sm text-gray-500">{{ $settings->primary_color }}</span>
                                </div>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Default color</p>
                            @endif
                        </div>
                        <x-heroicon-o-swatch class="w-5 h-5 text-gray-400" />
                    </div>
                </div>
            </x-filament::section>

            <!-- Localization Card -->
            <x-filament::section class="h-full">
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-language class="w-5 h-5 text-primary-500 mr-2" />
                        <span>Localization</span>
                    </div>
                </x-slot>
                <x-slot name="description" class="mt-1">
                    Regional settings for language, time, and date formats
                </x-slot>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Language</p>
                            <p class="mt-1 font-medium">{{ $settings->locale ?? 'System default' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Timezone</p>
                            <p class="mt-1 font-medium">{{ $settings->timezone ?? 'System default' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date Format</p>
                            <p class="mt-1 font-medium">{{ $settings->date_format ?? 'System default' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Time Format</p>
                            <p class="mt-1 font-medium">{{ $settings->time_format ?? 'System default' }}</p>
                        </div>
                    </div>
                </div>
            </x-filament::section>

            <!-- Security Card -->
            <x-filament::section class="h-full">
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-shield-check class="w-5 h-5 text-primary-500 mr-2" />
                        <span>Security</span>
                    </div>
                </x-slot>
                <x-slot name="description" class="mt-1">
                    Authentication and access control settings
                </x-slot>

                <div class="space-y-4">
                    <div class="flex items-center justify-between py-2">
                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300">Two-Factor Authentication</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Extra security layer for user accounts</p>
                        </div>
                        <x-filament::badge color="{{ $settings->require_2fa ? 'success' : 'gray' }}">
                            {{ $settings->require_2fa ? 'Required' : 'Optional' }}
                        </x-filament::badge>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300">Password Policy</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Rules for creating secure passwords</p>
                        </div>
                        <x-filament::badge color="gray">
                            {{ ucfirst($settings->password_policy ?? 'Standard') }}
                        </x-filament::badge>
                    </div>
                </div>
            </x-filament::section>

            <!-- Notifications Card -->
            <x-filament::section class="h-full">
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-bell class="w-5 h-5 text-primary-500 mr-2" />
                        <span>Notifications</span>
                    </div>
                </x-slot>
                <x-slot name="description" class="mt-1">
                    Configure how and when users receive alerts
                </x-slot>

                <div class="space-y-4">
                    <div class="flex items-center justify-between py-2">
                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300">Email Notifications</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Send alerts via email</p>
                        </div>
                        <x-filament::badge color="{{ $settings->email_notifications_enabled ? 'success' : 'gray' }}">
                            {{ $settings->email_notifications_enabled ? 'Enabled' : 'Disabled' }}
                        </x-filament::badge>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300">Project Changes</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Notify when projects are modified</p>
                        </div>
                        <x-filament::badge color="{{ $settings->notify_on_project_changes ? 'success' : 'gray' }}">
                            {{ $settings->notify_on_project_changes ? 'Enabled' : 'Disabled' }}
                        </x-filament::badge>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300">Task Assignment</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Notify when tasks are assigned</p>
                        </div>
                        <x-filament::badge color="{{ $settings->notify_on_task_assign ? 'success' : 'gray' }}">
                            {{ $settings->notify_on_task_assign ? 'Enabled' : 'Disabled' }}
                        </x-filament::badge>
                    </div>
                </div>
            </x-filament::section>

            <!-- Project Defaults Card -->
            <x-filament::section class="h-full">
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-folder-open class="w-5 h-5 text-primary-500 mr-2" />
                        <span>Project Defaults</span>
                    </div>
                </x-slot>
                <x-slot name="description" class="mt-1">
                    Default settings for new projects
                </x-slot>

                <div class="space-y-4">
                    <div class="flex items-center justify-between py-2">
                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300">Default Priority</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Initial priority for new projects</p>
                        </div>
                        <x-filament::badge color="blue">
                            {{ ucfirst($settings->project_default_priority ?? 'Medium') }}
                        </x-filament::badge>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300">Default Status</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Initial status for new projects</p>
                        </div>
                        <x-filament::badge color="blue">
                            {{ ucfirst(str_replace('_', ' ', $settings->project_default_status ?? 'Not started')) }}
                        </x-filament::badge>
                    </div>
                </div>
            </x-filament::section>

            <!-- Task Defaults Card -->
            <x-filament::section class="h-full">
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-clipboard-document-list class="w-5 h-5 text-primary-500 mr-2" />
                        <span>Task Defaults</span>
                    </div>
                </x-slot>
                <x-slot name="description" class="mt-1">
                    Default settings for new tasks
                </x-slot>

                <div class="space-y-4">
                    <div class="flex items-center justify-between py-2">
                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300">Default Priority</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Initial priority for new tasks</p>
                        </div>
                        <x-filament::badge color="blue">
                            {{ ucfirst($settings->task_default_priority ?? 'Medium') }}
                        </x-filament::badge>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300">Default Status</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Initial status for new tasks</p>
                        </div>
                        <x-filament::badge color="blue">
                            {{ ucfirst(str_replace('_', ' ', $settings->task_default_status ?? 'To do')) }}
                        </x-filament::badge>
                    </div>
                </div>
            </x-filament::section>

            <!-- Storage & Files Card -->
            <x-filament::section class="h-full">
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-server-stack class="w-5 h-5 text-primary-500 mr-2" />
                        <span>Storage & Files</span>
                    </div>
                </x-slot>
                <x-slot name="description" class="mt-1">
                    File upload and storage configuration
                </x-slot>

                <div class="space-y-4">
                    <div class="flex items-center justify-between py-2">
                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300">Upload Storage</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Where uploaded files are stored</p>
                        </div>
                        <x-filament::badge color="blue">
                            {{ ucfirst($settings->storage_upload_disk ?? 'Local') }}
                        </x-filament::badge>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300">Max File Size</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Maximum size for file uploads</p>
                        </div>
                        <x-filament::badge color="blue">
                            {{ $settings->storage_max_file_mb ? $settings->storage_max_file_mb . ' MB' : 'Unlimited' }}
                        </x-filament::badge>
                    </div>

                    <div class="py-2">
                        <p class="font-medium text-gray-700 dark:text-gray-300 mb-2">Allowed File Types</p>
                        @if($settings->allowed_file_types && is_array($settings->allowed_file_types))
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $colors = [
                                    'pdf' => 'primary',
                                    'doc' => 'secondary',
                                    'xls' => 'success',
                                    'ppt' => 'warning',
                                    'txt' => 'info',
                                    'jpg' => 'danger',
                                    'png' => 'gray',
                                    ];
                                @endphp
                                @foreach($settings->allowed_file_types as $type)
                                    <x-filament::badge size="sm" color="{{ $colors[$type] }}">
                                        {{ $type }}
                                    </x-filament::badge>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">All file types allowed</p>
                        @endif
                    </div>
                </div>
            </x-filament::section>

            <!-- User Experience Card -->
            <x-filament::section class="h-full">
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-cursor-arrow-rays class="w-5 h-5 text-primary-500 mr-2" />
                        <span>User Experience</span>
                    </div>
                </x-slot>
                <x-slot name="description" class="mt-1">
                    Interface and interaction preferences
                </x-slot>

                <div class="space-y-4">
                    <div class="flex items-center justify-between py-2">
                        <div>
                            <p class="font-medium text-gray-700 dark:text-gray-300">Sidebar Default State</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">How the sidebar appears initially</p>
                        </div>
                        <x-filament::badge color="{{ $settings->sidebar_collapsed_default ? 'warning' : 'success' }}">
                            {{ $settings->sidebar_collapsed_default ? 'Collapsed' : 'Expanded' }}
                        </x-filament::badge>
                    </div>
                </div>
            </x-filament::section>
        </div>
    </div>
</x-filament-panels::page>
