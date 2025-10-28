<?php

namespace App;

use App\Models\Team;
use App\Models\User;
use App\Jobs\RecordUserUsage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamUser extends Model
{
    use HasFactory;

    protected $table = 'team_user';

    protected static function booted(): void
    {
        static::created(function (TeamUser $teamUser) {
            if ($teamUser->team_id && $teamUser->user_id) {
                RecordUserUsage::dispatch($teamUser->team_id, $teamUser->user_id);
            }
        });
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
