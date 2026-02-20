<x-filament-panels::modal-modal id="custom-domain-verification" width="2xl">
    <x-slot name="heading">
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414 1.414L10 10.586a1 1 0 00-1.414 1.414 0 3.293 0 3.293A1 1 0 001.414 1.414 0 0 1.414-1.414 1.414 1.657 0 3.586-1.657-.707.106-.707.106 0 0 0-1.414-1.414-1.657v8.586a3 3 0 01.414 1.414 0 0 1.414-1.414 1.657z"/>
                    </svg>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Verify Your Domain</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    To activate <span class="font-medium text-gray-900 dark:text-white">{{ $record->domain }}</span>, 
                    add the following DNS record to your domain's DNS settings.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-6">
            <h4 class="text-md font-medium text-amber-800 dark:text-amber-100 mb-4">DNS Verification Record</h4>
            <div class="space-y-4">
                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Type:</span>
                        <span class="text-sm font-mono text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ $dnsRecord['type'] }}</span>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Name:</span>
                        <span class="text-sm font-mono text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded break-all">{{ $dnsRecord['name'] }}</span>
                        <button 
                            onclick="navigator.clipboard.writeText('{{ $dnsRecord['name'] }}')"
                            class="ml-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                            title="Copy to clipboard">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16a1 1 0 00-1 1v1a1 1 0 001 1 1h1a1 1 0 001 1v1a1 1 0 00-1-1h1a1 1 0 001-1v1a1 1 0 00-1-1h8a1 1 0 00-1 1v1a1 1 0 001 1-1h1a1 1 0 001 1v1a1 1 0 00-1-1z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Value:</span>
                        <span class="text-sm font-mono text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded break-all">{{ $dnsRecord['value'] }}</span>
                        <button 
                            onclick="navigator.clipboard.writeText('{{ $dnsRecord['value'] }}')"
                            class="ml-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                            title="Copy to clipboard">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16a1 1 0 00-1 1v1a1 1 0 001 1 1h1a1 1 0 001 1v1a1 1 0 00-1-1h1a1 1 0 001 1v1a1 1 0 00-1-1h8a1 1 0 00-1 1v1a1 1 0 001 1-1h1a1 1 0 001 1v1a1 1 0 00-1-1z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">TTL:</span>
                        <span class="text-sm font-mono text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ $dnsRecord['ttl'] }} seconds</span>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                <h4 class="text-md font-medium text-blue-800 dark:text-blue-100 mb-4">CNAME Record</h4>
                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Type:</span>
                        <span class="text-sm font-mono text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ $cnameRecord['type'] }}</span>
                        <button 
                            onclick="navigator.clipboard.writeText('{{ $cnameRecord['name'] }}')"
                            class="ml-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                            title="Copy to clipboard">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16a1 1 0 00-1 1v1a1 1 0 001 1 1h1a1 1 0 001 1v1a1 1 0 00-1-1h1a1 1 0 001 1v1a1 1 0 00-1-1h8a1 1 0 00-1 1v1a1 1 0 001 1-1h1a1 1 0 001 1v1a1 1 0 00-1-1z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Name:</span>
                        <span class="text-sm font-mono text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded break-all">{{ $cnameRecord['name'] }}</span>
                        <button 
                            onclick="navigator.clipboard.writeText('{{ $cnameRecord['name'] }}')"
                            class="ml-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                            title="Copy to clipboard">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16a1 1 0 00-1 1v1a1 1 0 001 1 1h1a1 1 0 001 1v1a1 1 0 00-1-1h1a1 1 0 001 1v1a1 1 0 00-1-1h8a1 1 0 00-1 1v1a1 1 0 001 1-1h1a1 1 0 001 1v1a1 1 0 00-1-1z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Value:</span>
                        <span class="text-sm font-mono text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded break-all">{{ $cnameRecord['value'] }}</span>
                        <button 
                            onclick="navigator.clipboard.writeText('{{ $cnameRecord['value'] }}')"
                            class="ml-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                            title="Copy to clipboard">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16a1 1 0 00-1 1v1a1 1 0 001 1 1h1a1 1 0 001 1v1a1 1 0 00-1-1h1a1 1 0 001 1v1a1 1 0 00-1-1h8a1 1 0 00-1 1v1a1 1 0 001 1-1h1a1 1 0 001 1v1a1 1 0 00-1-1z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">TTL:</span>
                        <span class="text-sm font-mono text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ $cnameRecord['ttl'] }} seconds</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-sm text-gray-600 dark:text-gray-400">
            <p class="mb-2">
                <strong>Important:</strong> DNS changes may take up to 24-48 hours to propagate worldwide.
            </p>
            <p>
                After adding the DNS records, click the "Verify Domain" button in the Custom Domains page to complete the verification process.
            </p>
        </div>
    </div>
</x-filament-panels::modal-modal>
