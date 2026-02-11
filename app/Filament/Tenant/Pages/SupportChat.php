<?php

namespace App\Filament\Tenant\Pages;

use App\Models\History;
use App\Services\SupportChatService;
use Filament\Pages\Page;
use App\Models\SupportChat as SupportChatModel;
use BackedEnum;
use Laravel\Ai\Messages\Message;

class SupportChat extends Page
{
    protected string $view = 'filament.tenant.pages.support-chat';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';


    public $message = '';

    public function getMessagesProperty(){
        return History::orderBy('id', 'desc')->where('user_id', auth()->id())
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

        $chat = app(SupportChatService::class)
            ->send($prompt, auth()->user(), tenant: filament()->getTenant());

    }

}
