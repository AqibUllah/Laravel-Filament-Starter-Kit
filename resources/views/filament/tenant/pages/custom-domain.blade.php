<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Custom Domains</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Manage your custom domains for your application. Add, verify, and configure custom domains to give your application a professional look.
                    </p>
                </div>
                @if(filament()->getTenant()->customDomains()->count() > 0)
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        {{ filament()->getTenant()->customDomains()->count() }} domain(s) configured
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-md font-medium text-gray-900 dark:text-white mb-4">Setup Instructions</h3>
            <div class="space-y-4 text-sm text-gray-600 dark:text-gray-400">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-full flex items-center justify-center text-xs font-medium">1</div>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Add your domain</p>
                        <p>Enter your custom domain name (e.g., example.com) and click "Add Custom Domain".</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-full flex items-center justify-center text-xs font-medium">2</div>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Configure DNS</p>
                        <p>Add a CNAME record in your DNS settings pointing to your application.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-full flex items-center justify-center text-xs font-medium">3</div>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Verify domain</p>
                        <p>Click "Verify Domain" to confirm your DNS configuration and activate your custom domain.</p>
                    </div>
                </div>
            </div>
        </div>

        {{ $this->table }}
    </div>
</x-filament-panels::page>
