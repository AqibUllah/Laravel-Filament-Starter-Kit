<?php

namespace App\Services;

use App\Ai\Agents\SupportBot;
use App\Jobs\AiAgentErrorExplanation;
use App\Models\History;
use Filament\Notifications\Notification;

class SupportChatService
{
    public function send(string $message, $user)
    {

        try {
            $bot = new SupportBot($user,$message);

            $conversation = $bot->forUser($user); // bind to user

            $response = $conversation->prompt($message);

            History::where('conversation_id',$response->conversationId)
                ->update(['team_id' => filament()->getTenant()?->id]);

            return $response;
        } catch (\Throwable $e) {

            \Log::error('Chat mode error: '.$e->getMessage());
            Notification::make()
                ->title('AI Error: Something went wrong while processing your request.')
                ->body($e->getMessage())
                ->danger()
                ->send();
            AiAgentErrorExplanation::dispatch($user,"Explain this Laravel AI SDK error in simple terms: {$e->getMessage()}");
        }
    }
}
