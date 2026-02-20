<?php

namespace App\Jobs;

use App\Events\StorageQuotaExceeded;
use App\Models\EmailTemplate;
use App\Models\Team;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Action;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Filament\Notifications\Notification as FilamentNotification;

class SendStorageQuotaNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public StorageQuotaExceeded $event
    ) {}

    public function handle(): void
    {
        $team = $this->event->team;
        $user = $team->owner;

        // Send Filament notification to the user
        $this->sendFilamentNotification($user);

        // Send email notification
        $this->sendEmailNotification($user, $team);

        // Broadcast the event for real-time updates
        broadcast($this->event);
    }

    private function sendFilamentNotification(User $user): void
    {
        FilamentNotification::make()
            ->title('Storage Quota Exceeded')
            ->body("You attempted to upload {$this->event->formattedRequestedSize} but only have {$this->event->formattedRemainingStorage} remaining. Your current usage is {$this->event->formattedCurrentUsage} of {$this->event->formattedMaxStorage}.")
            ->warning()
            ->persistent()
            ->actions([
                Action::make('upgrade_plan')
                    ->label('Upgrade Plan')
                    ->url(route('filament.tenant.plans', ['tenant' => $this->event->team]))
                    ->button(),
                Action::make('manage_files')
                    ->label('Manage Files')
                    ->url(route('filament.tenant.resources.files.index', ['tenant' => $this->event->team]))
                    ->button(),
            ])
            ->sendToDatabase($user);
    }

    private function sendEmailNotification(User $user, Team $team): void
    {
        // Get email template for storage quota exceeded
        $template = EmailTemplate::where('team_id', $team->id)
            ->orWhere('team_id', null) // Fall back to global template
            ->where('key', 'storage-quota-exceeded')
            ->first();

        if (!$template) {
            // Fallback to default template
            $this->sendDefaultEmail($user, $team);
            return;
        }

        // Replace template variables
        $subject = $this->replaceTemplateVariables($template->subject, $user, $team);
        $content = $this->replaceTemplateVariables($template->content, $user, $team);

        // Send email using the template
        Mail::send([], [], function ($message) use ($user, $subject, $content) {
            $message->to($user->email)
                ->subject($subject)
                ->html($content);
        });
    }

    private function sendDefaultEmail(User $user, Team $team): void
    {
        $subject = "Storage Quota Exceeded - {$team->name}";
        $content = $this->getDefaultEmailContent($user, $team);

        Mail::send([], [], function ($message) use ($user, $subject, $content) {
            $message->to($user->email)
                ->subject($subject)
                ->html($content);
        });
    }

    private function replaceTemplateVariables(string $content, User $user, Team $team): string
    {
        return str_replace([
            '##user_name##',
            '##team_name##',
            '##current_usage##',
            '##max_storage##',
            '##requested_size##',
            '##remaining_storage##',
            '##upgrade_url##',
            '##config.app.name##',
        ], [
            $user->name,
            $team->name,
            $this->event->formattedCurrentUsage,
            $this->event->formattedMaxStorage,
            $this->event->formattedRequestedSize,
            $this->event->formattedRemainingStorage,
            route('filament.tenant.pages.plans', ['tenant' => $team]),
            config('app.name'),
        ], $content);
    }

    private function getDefaultEmailContent(User $user, Team $team): string
    {
        $upgradeUrl = route('filament.tenant.pages.plans', ['tenant' => $team]);

        return "
            <h2>Storage Quota Exceeded</h2>
            <p>Dear {$user->name},</p>
            <p>You attempted to upload a file of {$this->event->formattedRequestedSize} to your team <strong>{$team->name}</strong>, but you have exceeded your storage quota.</p>

            <h3>Current Storage Status:</h3>
            <ul>
                <li><strong>Current Usage:</strong> {$this->event->formattedCurrentUsage}</li>
                <li><strong>Storage Limit:</strong> {$this->event->formattedMaxStorage}</li>
                <li><strong>Remaining Space:</strong> {$this->event->formattedRemainingStorage}</li>
                <li><strong>Requested Upload:</strong> {$this->event->formattedRequestedSize}</li>
            </ul>

            <h3>What can you do?</h3>
            <p>You have two options to resolve this:</p>
            <ol>
                <li><strong>Upgrade your plan</strong> to get more storage space</li>
                <li><strong>Delete some files</strong> to free up space</li>
            </ol>

            <div style='text-align: center; margin: 20px 0;'>
                <a href='{$upgradeUrl}' style='background-color: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin-right: 10px;'>Upgrade Plan</a>
                <a href='{$manageFilesUrl}' style='background-color: #6b7280; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px;'>Manage Files</a>
            </div>

            <p>Best regards,<br>The Team</p>
        ";
    }
}
