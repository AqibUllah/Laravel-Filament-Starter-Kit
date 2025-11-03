@if(empty($data))
    <div class="flex items-center justify-center p-12 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg">
        <div class="text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">No Template Selected</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Please select a template from the dropdown to preview your theme design.</p>
        </div>
    </div>
@else
    @include('vb-email-templates::email.default_preview', ['data' => $data])
@endif

