<?php

namespace App\Notifications;

use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Mail\TemplateMailable;

class ProjectCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Project $project;

    /**
     * Create a new notification instance.
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
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
        return (new TemplateMailable('project-created'))
            ->to($notifiable->email)
            ->subject('New Project Created: ' . $this->project->name)
            ->with([
                'user' => $notifiable,
                'project' => $this->project,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => $this->project->id,
            'project_name' => $this->project->name,
            'message' => 'A new project has been created: ' . $this->project->name,
        ];
    }
}