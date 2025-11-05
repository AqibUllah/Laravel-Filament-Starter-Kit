<?php

use App\Mail\TemplateMailable;
use Illuminate\Support\Facades\Mail;
use Visualbuilder\EmailTemplates\Models\EmailTemplate;

test('can send an email with template', function () {
    Mail::fake();

    // Create a test template with unique key
    $uniqueKey = 'test-template-' . uniqid();
    $template = EmailTemplate::create([
        'name' => 'Test Template',
        'key' => $uniqueKey,
        'subject' => 'Test Subject',
        'content' => '<p>Hello {{ $name }},</p><p>This is a test email.</p>',
    ]);

    // Create and send email
    $email = new TemplateMailable(
        $uniqueKey,
        ['name' => 'John Doe'],
        'test@example.com'
    );

    Mail::to('test@example.com')->send($email);

    // Assert that the email was sent
    Mail::assertSent(TemplateMailable::class, function ($mail) {
        return $mail->hasTo('test@example.com');
    });
});
