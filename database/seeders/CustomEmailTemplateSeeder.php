<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomEmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'key' => 'project-created',
                'language' => 'en_GB',
                'view' => 'default',
                'from' => json_encode(['email' => config('mail.from.address'), 'name' => config('mail.from.name')]),
                'name' => 'Project Created Notification',
                'preheader' => 'A new project has been created',
                'subject' => 'New Project Created: ##project.name##',
                'title' => 'New Project Created',
                'content' => '<p>Dear ##user.name##,</p>
                            <p>A new project has been created: <strong>##project.name##</strong></p>
                            <p>Project Description: ##project.description##</p>
                            <p>Status: ##project.status##</p>
                            <p>You can view the project details by logging into your account.</p>
                            <p>Kind Regards,<br>
                            ##config.app.name##</p>',
                'logo' => 'media/email-templates/logo.png',
                'team_id' => Team::first()->id,
            ],
            [
                'key' => 'task-assigned',
                'language' => 'en_GB',
                'view' => 'default',
                'from' => json_encode(['email' => config('mail.from.address'), 'name' => config('mail.from.name')]),
                'name' => 'Task Assigned Notification',
                'preheader' => 'You have been assigned a new task',
                'subject' => 'Task Assigned: ##task.title##',
                'title' => 'New Task Assignment',
                'content' => '<p>Dear ##user.name##,</p>
                            <p>You have been assigned a new task: <strong>##task.title##</strong></p>
                            <p>Task Description: ##task.description##</p>
                            <p>Project: ##project.name##</p>
                            <p>Due Date: ##task.due_date##</p>
                            <p>Priority: ##task.priority##</p>
                            <p>You can view the task details by logging into your account.</p>
                            <p>Kind Regards,<br>
                            ##config.app.name##</p>',
                'logo' => 'media/email-templates/logo.png',
                'team_id' => Team::first()->id,
            ],
            [
                'key' => 'team-invitation',
                'language' => 'en_GB',
                'view' => 'default',
                'from' => json_encode(['email' => config('mail.from.address'), 'name' => config('mail.from.name')]),
                'name' => 'Team Invitation Notification',
                'preheader' => 'You have been invited to join a team',
                'subject' => 'Invitation to join team: ##team.name##',
                'title' => 'Team Invitation',
                'content' => '<p>Dear ##user.name##,</p>
                            <p>You have been invited to join the team: <strong>##team.name##</strong></p>
                            <p>To accept this invitation, please click the button below:</p>
                            <p><a href="##acceptUrl##" style="display: inline-block; background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Accept Invitation</a></p>
                            <p>If the button doesn\'t work, you can copy and paste the following URL into your browser:</p>
                            <p>##acceptUrl##</p>
                            <p>This invitation will expire in 7 days.</p>
                            <p>Kind Regards,<br>
                            ##config.app.name##</p>',
                'logo' => 'media/email-templates/logo.png',
                'team_id' => Team::first()->id,
            ],
            [
                'key' => 'storage-quota-exceeded',
                'language' => 'en_GB',
                'view' => 'default',
                'from' => json_encode(['email' => config('mail.from.address'), 'name' => config('mail.from.name')]),
                'name' => 'Storage Quota Exceeded',
                'preheader' => 'Your storage quota has been exceeded',
                'subject' => 'Storage Quota Exceeded - ##team.name##',
                'title' => 'Storage Quota Exceeded',
                'content' => '<h2>Storage Quota Exceeded</h2>
                            <p>Dear ##user.name##,</p>
                            <p>You attempted to upload a file of ##requested_size## to your team <strong>##team.name##</strong>, but you have exceeded your storage quota.</p>
                            
                            <h3>Current Storage Status:</h3>
                            <ul>
                                <li><strong>Current Usage:</strong> ##current_usage##</li>
                                <li><strong>Storage Limit:</strong> ##max_storage##</li>
                                <li><strong>Remaining Space:</strong> ##remaining_storage##</li>
                                <li><strong>Requested Upload:</strong> ##requested_size##</li>
                            </ul>
                            
                            <h3>What can you do?</h3>
                            <p>You have two options to resolve this:</p>
                            <ol>
                                <li><strong>Upgrade your plan</strong> to get more storage space</li>
                                <li><strong>Delete some files</strong> to free up space</li>
                            </ol>
                            
                            <div style="text-align: center; margin: 20px 0;">
                                <a href="##upgrade_url##" style="background-color: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin-right: 10px;">Upgrade Plan</a>
                                <a href="##manage_files_url##" style="background-color: #6b7280; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px;">Manage Files</a>
                            </div>
                            
                            <p>Best regards,<br>##config.app.name##</p>',
                'logo' => 'media/email-templates/logo.png',
                'team_id' => null, // Global template
            ],
        ];

        foreach ($templates as $template) {
            DB::table('vb_email_templates')->updateOrInsert(
                ['key' => $template['key'], 'language' => $template['language']],
                array_merge($template, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
