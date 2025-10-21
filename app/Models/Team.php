<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'domain',
        'status',
        'logo',
        'owner_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    // ... existing code ...

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

    public function hasActiveSubscription(): bool
    {
        return $this->subscription && $this->subscription->isActive();
    }

    public function isOnTrial(): bool
    {
        return $this->subscription && $this->subscription->isOnTrial();
    }

    public function canAccessFeature(string $feature): bool
    {
        if (!$this->subscription) {
            return false;
        }

        $planFeature = $this->subscription->plan->features()
            ->where('name', $feature)
            ->first();

        if (!$planFeature) {
            return false;
        }

        return (bool) $planFeature->value;
    }

    public function getRemainingTrialDays(): int
    {
        if (!$this->isOnTrial()) {
            return 0;
        }

        return $this->subscription->trial_ends_at->diffInDays(now());
    }

    public function owner()
    {
        return $this->users()->wherePivot('role', 'owner')->first();
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id')
            ->withTimestamps();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    // Check if user can assign tasks
    public function userCanAssignTasks(User $user): bool
    {
        return $this->users()->where('user_id', $user->id)->whereIn('role', ['owner', 'admin', 'super_admin'])->exists();
    }

}
