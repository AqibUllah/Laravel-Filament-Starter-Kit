<?php

namespace App\Services;

use App\Events\TeamInvitation;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Str;

class TeamInvitationService
{
    /**
     * Invite a user to a team
     */
    public function inviteUser(Team $team, string $email): void
    {
        // Find or create the user
        $user = User::firstOrCreate(['email' => $email], [
            'name' => 'Invited User',
            'password' => bcrypt(Str::random(16)),
        ]);
        
        // Generate invitation token
        $invitationToken = Str::random(32);
        
        // Store the invitation token (you might want to create an invitations table)
        // For now, we'll just dispatch the event
        
        // Dispatch the team invitation event
        event(new TeamInvitation($team, $user, $invitationToken));
    }
}