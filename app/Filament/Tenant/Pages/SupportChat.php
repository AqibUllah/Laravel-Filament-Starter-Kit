<?php

namespace App\Filament\Tenant\Pages;

use App\Models\History;
use App\Services\SupportChatService;
use Filament\Pages\Page;
use BackedEnum;
use Laravel\Ai\Messages\Message;
use Illuminate\Support\Facades\Log;

class SupportChat extends Page
{
    protected string $view = 'filament.tenant.pages.support-chat';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public $message = '';
    public $selectedMode = 'chat';

    // Handle mode changes
    public function changeMode($mode)
    {
        $this->selectedMode = $mode;
        $this->dispatch('modeChanged', mode: $mode);
    }

    public function getMessagesProperty()
    {
        return History::orderBy('id', 'desc')
            ->current_team()
            ->where('user_id', auth()->id())
            ->latest()
            ->limit(50)
            ->get()
            ->reverse()
            ->map(function ($message) {
                return new Message($message->role, $message->content);
            });
    }

    public function send()
    {
        if (blank($this->message)) {
            return;
        }

        $this->dispatch('scrollToBottom');

        $prompt = $this->message;
        $this->message = '';

        $this->handleChatMode($prompt);
    }

    private function handleChatMode($prompt): void
    {
        try {
            app(SupportChatService::class)
                ->send($prompt, auth()->user());
        } catch (\Exception $e) {
            Log::error('Chat mode error: ' . $e->getMessage());
        }
    }
}
