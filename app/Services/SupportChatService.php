<?php

namespace App\Services;

use App\Ai\Agents\SupportBot;
use App\Models\History;
use App\Models\SupportChat;

class SupportChatService
{
    public function send(string $message, $user)
    {
        $bot = new SupportBot($user);

        $conversation = $bot->forUser($user); // bind to user

        $response = $conversation->prompt($message);

        History::where('conversation_id',$response->conversationId)
        ->update(['team_id' => filament()->getTenant()?->id]);

        return $response;
    }
}
