<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Visualbuilder\EmailTemplates\Facades\TokenHelper;
use Visualbuilder\EmailTemplates\Traits\BuildGenericEmail;

class TemplateMailable extends Mailable
{
    use BuildGenericEmail;
    use Queueable;
    use SerializesModels;

    public $template;

    public $sendTo;

    public $emailTemplate;

    public $data = [];

    // Public properties for token replacement
    public $user;

    public $project;

    public $task;

    public $team;

    public $acceptUrl;

    public $teamId;

    /**
     * Create a new message instance.
     *
     * @param  string  $template  The email template key
     * @return void
     */
    public function __construct(string $template, array $data = [], string $sendTo = '')
    {
        $this->template = $template;
        $this->data = $data;
        $this->sendTo = $sendTo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $resolvedTeamId = $this->teamId
            ?? ($this->team->id ?? null)
            ?? ($this->project->team_id ?? null)
            ?? ($this->task->team_id ?? null);

        $this->emailTemplate = EmailTemplate::findEmailByKey(
            $this->template,
            App::currentLocale(),
            $resolvedTeamId
        );

        if (! $this->emailTemplate) {
            Log::warning("Email template {$this->template} was not found.");

            return $this;
        }

        // Safely get theme colours with null check
        $themeColours = ($this->emailTemplate->theme && $this->emailTemplate->theme->colours)
            ? $this->emailTemplate->theme->colours
            : [];

        // Build a token-safe models object to avoid passing enums/objects into str_replace
        $tokenModels = (object) [
            'user' => $this->user,
            'project' => $this->project ? (object) $this->project->toArray() : null,
            'task' => $this->task ? (object) $this->task->toArray() : null,
            'team' => $this->team ? (object) $this->team->toArray() : null,
            'acceptUrl' => $this->acceptUrl ?? null,
            'emailTemplate' => $this->emailTemplate,
        ];

        $viewData = [
            'content' => TokenHelper::replace($this->emailTemplate->content ?? '', $tokenModels),
            'preHeaderText' => TokenHelper::replace($this->emailTemplate->preheader ?? '', $tokenModels),
            'title' => TokenHelper::replace($this->emailTemplate->title ?? '', $tokenModels),
            'theme' => $themeColours,
            'logo' => $this->emailTemplate->logo,
        ];

        // Ensure theme has safe defaults to avoid undefined index errors in views
        if (! is_array($viewData['theme']) || empty($viewData['theme'])) {
            $viewData['theme'] = [
                'anchor_color' => '#1a82e2',
                'header_bg_color' => '#f2f2f2',
                'body_bg_color' => '#f9f9f9',
                'content_bg_color' => '#ffffff',
                'body_color' => '#000000',
                'footer_bg_color' => '#f2f2f2',
                'button_bg_color' => '#1a82e2',
                'button_color' => '#ffffff',
                'callout_bg_color' => '#f2f2f2',
                'callout_color' => '#333333',
            ];
        }

        if (is_array($this->emailTemplate->cc) && count($this->emailTemplate->cc)) {
            $this->cc($this->emailTemplate->cc);
        }

        if (is_array($this->emailTemplate->bcc) && count($this->emailTemplate->bcc)) {
            $this->bcc($this->emailTemplate->bcc);
        }

        // Handle "from" which may be stored as an array or a JSON string
        $from = is_array($this->emailTemplate->from)
            ? $this->emailTemplate->from
            : json_decode((string) $this->emailTemplate->from, true);

        if (is_array($from) && isset($from['email'])) {
            $this->from($from['email'], $from['name'] ?? config('mail.from.name'));
        }

        $this->subject(TokenHelper::replace($this->emailTemplate->subject ?? '', $tokenModels));

        $view = $this->emailTemplate->view ?? 'default';

        return $this->view("vb-email-templates::email.{$view}", ['data' => $viewData]);
    }
}
