<?php

namespace App\Ai\Agents;

use App\Ai\Tools\TextToAudioTool;
use App\Models\User;
use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Promptable;
use Stringable;

class TextToAudioAgent implements Agent, Conversational, HasTools
{
    use Promptable,RemembersConversations;

    public function __construct(public User $user,public $prompt){}

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'You are a helpful text to audio generator.';
    }

    /**
     * Get the list of messages comprising the conversation so far.
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [
            new TextToAudioTool($this->prompt)
        ];
    }
}
