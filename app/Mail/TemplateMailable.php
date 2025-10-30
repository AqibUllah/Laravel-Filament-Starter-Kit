<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Visualbuilder\EmailTemplates\Facades\TokenHelper;
use Visualbuilder\EmailTemplates\Models\EmailTemplate;
use Visualbuilder\EmailTemplates\Traits\BuildGenericEmail;

class TemplateMailable extends Mailable
{
    use Queueable;
    use SerializesModels;
    use BuildGenericEmail;

    public $template;
    public $data = [];
    public $sendTo;
    public $emailTemplate;

    /**
     * Create a new message instance.
     *
     * @param string $template The email template key
     * @return void
     */
    public function __construct(string $template)
    {
        $this->template = $template;
    }

    /**
     * Set the view data for the message.
     *
     * @param  string|array  $key
     * @param  mixed  $value
     * @return $this
     */
    public function with($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->emailTemplate = EmailTemplate::findEmailByKey($this->template, App::currentLocale());

        if (!$this->emailTemplate) {
            Log::warning("Email template {$this->template} was not found.");
            return $this;
        }

        $viewData = [
            'content'       => TokenHelper::replace($this->emailTemplate->content ?? '', $this),
            'preHeaderText' => TokenHelper::replace($this->emailTemplate->preheader ?? '', $this),
            'title'         => TokenHelper::replace($this->emailTemplate->title ?? '', $this),
            'theme'         => $this->emailTemplate->theme?->colours ?? null,
            'logo'          => $this->emailTemplate->logo,
        ];

        // Ensure theme has safe defaults to avoid undefined index errors in views
        $defaultColours = [
            'anchor_color'      => '#1a82e2',
            'header_bg_color'   => '#f2f2f2',
            'body_bg_color'     => '#f9f9f9',
            'content_bg_color'  => '#ffffff',
            'body_color'        => '#000000',
            'footer_bg_color'   => '#f2f2f2',
            'button_bg_color'   => '#1a82e2',
            'button_color'      => '#ffffff',
            'callout_bg_color'  => '#f2f2f2',
            'callout_color'     => '#333333',
            'default'           => '#333333',
        ];

        $themeColours = is_array($viewData['theme']) ? $viewData['theme'] : [];
        $viewData['theme'] = array_merge($defaultColours, $themeColours);

        if (is_array($this->emailTemplate->cc) && count($this->emailTemplate->cc)) {
            $this->cc($this->emailTemplate->cc);
        }

        // Handle "from" which may be stored as an array or a JSON string
        $from = is_array($this->emailTemplate->from)
            ? $this->emailTemplate->from
            : json_decode((string) $this->emailTemplate->from, true);

        if (is_array($from) && isset($from['email'])) {
            $this->from($from['email'], $from['name'] ?? config('mail.from.name'));
        }

        $this->subject(TokenHelper::replace($this->emailTemplate->subject ?? '', $this));

        $view = $this->emailTemplate->view ?? 'default';

        return $this->view("vb-email-templates::email.{$view}", ['data' => $viewData]);
    }
}
