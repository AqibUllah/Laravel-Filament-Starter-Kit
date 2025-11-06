<?php

namespace App\Services;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailCampaignService
{
    public function sendCampaignEmail(Team $team, User $recipient, string $subject, string $body, int $campaignId): bool
    {
        // Optional: enforce plan feature limits before sending
        $limits = app(UsageService::class)->checkUsageLimits($team, 'emails_sent', 1);
        if (! $limits['allowed']) {
            return false; // or throw an exception / notify user
        }

        // Send the email (simple raw example)
        Mail::raw($body, function ($message) use ($recipient, $subject) {
            $message->to($recipient->email)->subject($subject);
        });

        // Record metered usage asynchronously
        \App\Jobs\RecordEmailsSentUsage::dispatch($team->id, $campaignId, 1, 0.01);

        return true;
    }
}
