<?php

namespace App\Notifications;

use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Mail\TemplateMailable;

class TaskAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Task $task;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
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
        return (new TemplateMailable('task-assigned'))
            ->to($notifiable->email)
            ->subject('Task Assigned: ' . $this->task->title)
            ->with([
                'user' => $notifiable,
                'task' => $this->task,
                'project' => $this->task->project,
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
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'project_id' => $this->task->project_id,
            'message' => 'You have been assigned a new task: ' . $this->task->title,
        ];
    }
}