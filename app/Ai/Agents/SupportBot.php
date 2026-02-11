<?php

namespace App\Ai\Agents;

use App\Ai\Tools\ProjectTool;
use App\Models\History;
use App\Models\User;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Promptable;
use Stringable;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Messages\Message;

#[Provider('groq')]
class SupportBot implements Agent, Conversational, HasTools
{
    use Promptable,RemembersConversations;

    public function __construct(public User $user) {}

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return <<<EOT
            You are a professional SaaS support assistant.

            Rules:
            - Be polite and professional.
            - Give short and clear answers.
            - If the user question is unclear, ask for clarification.
            - If you don't know something, say you will escalate to human support.
            - Never make up features that do not exist.
            EOT;
    }

    /**
     * Get the list of messages comprising the conversation so far.
     */
    public function messages(): iterable
    {
        return History::where('user_id', $this->user->id)
            ->latest()
            ->limit(50)
            ->get()
            ->reverse()
            ->map(function ($message) {
                return new Message($message->role, $message->content);
            })->all();
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [
            new ProjectTool
        ];
    }
}
