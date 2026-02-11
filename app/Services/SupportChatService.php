<?php

namespace App\Services;

use App\Ai\Agents\SupportBot;
use App\Models\SupportChat;

class SupportChatService
{
    public function send(string $message, $user, $tenant = null)
    {
        $bot = new SupportBot($user);

        $conversation = $bot->forUser($user); // bind to user

        return $conversation->prompt($message);
    }
}
