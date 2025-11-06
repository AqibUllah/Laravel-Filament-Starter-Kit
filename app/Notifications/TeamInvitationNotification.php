<?php

namespace App\Notifications;

use App\Mail\TemplateMailable;
use App\Models\Team;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class TeamInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Team $team;

    protected string $invitationToken;

    /**
     * Create a new notification instance.
     */
    public function __construct(Team $team, string $invitationToken)
    {
        $this->team = $team;
        $this->invitationToken = $invitationToken;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $notifiable): TemplateMailable
    {
        $acceptUrl = url('/team-invitations/'.$this->invitationToken);

        $mailable = new TemplateMailable('team-invitation');
        $mailable->sendTo = $notifiable->email;
        $mailable->user = $notifiable;
        $mailable->team = $this->team;
        $mailable->acceptUrl = $acceptUrl;

        return $mailable->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'team_id' => $this->team->id,
            'team_name' => $this->team->name,
            'message' => 'You have been invited to join the team: '.$this->team->name,
        ];
    }
}
