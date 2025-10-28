<x-filament-panels::page>
    @php($settings = app(\App\Settings\TenantGeneralSettings::class))

    <div class="space-y-6">
        {{-- Branding --}}
        <x-filament::section>
            <x-slot name="heading">Branding</x-slot>

            <div class="grid gap-4">
                <div>
                    <span class="font-medium">Company Name:</span>
                    <span>{{ $settings->company_name ?? '—' }}</span>
                </div>

                @if(!empty($settings->company_logo_path))
                    <div class="flex items-center gap-3">
                        <span class="font-medium">Company Logo:</span>
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($settings->company_logo_path) }}" alt="Company Logo" class="h-10 rounded" />
                    </div>
                @endif

                <div class="flex items-center gap-3">
                    <span class="font-medium">Primary Color:</span>
                    @if(!empty($settings->primary_color))
                        <span class="inline-block h-5 w-10 rounded" style="background-color: {{ $settings->primary_color }}"></span>
                        <span>{{ $settings->primary_color }}</span>
                    @else
                        <span>—</span>
                    @endif
                </div>
            </div>
        </x-filament::section>

        {{-- Localization --}}
        <x-filament::section>
            <x-slot name="heading">Localization</x-slot>

            <div class="grid gap-4">
                <div>
                    <span class="font-medium">Language:</span>
                    <span>{{ $settings->locale ?? '—' }}</span>
                </div>
                <div>
                    <span class="font-medium">Timezone:</span>
                    <span>{{ $settings->timezone ?? '—' }}</span>
                </div>
                <div>
                    <span class="font-medium">Date Format:</span>
                    <span>{{ $settings->date_format ?? '—' }}</span>
                </div>
                <div>
                    <span class="font-medium">Time Format:</span>
                    <span>{{ $settings->time_format ?? '—' }}</span>
                </div>
            </div>
        </x-filament::section>

        {{-- Security --}}
        <x-filament::section>
            <x-slot name="heading">Security</x-slot>

            <div class="grid gap-4">
                <div>
                    <span class="font-medium">Two-Factor Authentication:</span>
                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full {{ $settings->require_2fa ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $settings->require_2fa ? 'Required' : 'Optional' }}
                    </span>
                </div>
                <div>
                    <span class="font-medium">Password Policy:</span>
                    <span>{{ ucfirst($settings->password_policy ?? 'Not set') }}</span>
                </div>
            </div>
        </x-filament::section>

        {{-- Project Defaults --}}
        <x-filament::section>
            <x-slot name="heading">Project Defaults</x-slot>

            <div class="grid gap-4">
                <div>
                    <span class="font-medium">Default Priority:</span>
                    <span>{{ ucfirst($settings->project_default_priority ?? '—') }}</span>
                </div>
                <div>
                    <span class="font-medium">Default Status:</span>
                    <span>{{ ucfirst(str_replace('_', ' ', $settings->project_default_status ?? '—')) }}</span>
                </div>
            </div>
        </x-filament::section>

        {{-- Task Defaults --}}
        <x-filament::section>
            <x-slot name="heading">Task Defaults</x-slot>

            <div class="grid gap-4">
                <div>
                    <span class="font-medium">Default Priority:</span>
                    <span>{{ ucfirst($settings->task_default_priority ?? '—') }}</span>
                </div>
                <div>
                    <span class="font-medium">Default Status:</span>
                    <span>{{ ucfirst(str_replace('_', ' ', $settings->task_default_status ?? '—')) }}</span>
                </div>
            </div>
        </x-filament::section>

        {{-- Notifications --}}
        <x-filament::section>
            <x-slot name="heading">Notifications</x-slot>

            <div class="grid gap-4">
                <div>
                    <span class="font-medium">Email Notifications:</span>
                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full {{ $settings->email_notifications_enabled ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $settings->email_notifications_enabled ? 'Enabled' : 'Disabled' }}
                    </span>
                </div>
                <div>
                    <span class="font-medium">Project Changes:</span>
                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full {{ $settings->notify_on_project_changes ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $settings->notify_on_project_changes ? 'Enabled' : 'Disabled' }}
                    </span>
                </div>
                <div>
                    <span class="font-medium">Task Assignment:</span>
                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full {{ $settings->notify_on_task_assign ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $settings->notify_on_task_assign ? 'Enabled' : 'Disabled' }}
                    </span>
                </div>
            </div>
        </x-filament::section>

        {{-- Storage & Files --}}
        <x-filament::section>
            <x-slot name="heading">Storage & Files</x-slot>

            <div class="grid gap-4">
                <div>
                    <span class="font-medium">Upload Storage:</span>
                    <span>{{ ucfirst($settings->storage_upload_disk ?? '—') }}</span>
                </div>
                <div>
                    <span class="font-medium">Max File Size:</span>
                    <span>{{ $settings->storage_max_file_mb ? $settings->storage_max_file_mb . ' MB' : '—' }}</span>
                </div>
                <div>
                    <span class="font-medium">Allowed File Types:</span>
                    @if($settings->allowed_file_types && is_array($settings->allowed_file_types))
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach($settings->allowed_file_types as $type)
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">
                                    {{ $type }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <span>—</span>
                    @endif
                </div>
            </div>
        </x-filament::section>

        {{-- User Experience --}}
        <x-filament::section>
            <x-slot name="heading">User Experience</x-slot>

            <div class="grid gap-4">
                <div>
                    <span class="font-medium">Sidebar Default:</span>
                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full {{ $settings->sidebar_collapsed_default ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800' }}">
                        {{ $settings->sidebar_collapsed_default ? 'Collapsed' : 'Expanded' }}
                    </span>
                </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>


