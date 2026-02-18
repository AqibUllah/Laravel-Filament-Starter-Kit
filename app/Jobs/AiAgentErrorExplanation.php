<?php

namespace App\Jobs;

use App\Ai\Agents\SupportBot;
use App\Models\History;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AiAgentErrorExplanation implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $user,public $error_message)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $bot = new SupportBot($this->user,$this->error_message);

        $conversation = $bot->forUser($this->user); // bind to user

        $response = $conversation->prompt($this->error_message);

        History::where('conversation_id',$response->conversationId)
            ->update(['team_id' => filament()->getTenant()?->id]);
    }
}
