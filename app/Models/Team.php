<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'current_plan_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    // ... existing code ...

    // ... existing code ...

    public function currentPlan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'current_plan_id');
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class)
            ->where('status', 'active')->withoutGlobalScopes();
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class)->withoutGlobalScopes();
    }

    public function hasActiveSubscription(): bool
    {
        return $this->subscription && $this->subscription->isActive();
    }

    public function isOnTrial(): bool
    {
        return $this->subscription && $this->subscription->isOnTrial();
    }

    public function featureValue(string $featureCode, $default = null)
    {
        $subscription = $this->subscription;

        if (! $subscription || ! $subscription->plan) {
            return $default;
        }

        return optional(
            $subscription->plan->features->firstWhere('name', $featureCode)
        )->value ?? $default;
    }

    public function canAccessFeature(string $feature): bool
    {
        if (! $this->subscription) {
            return false;
        }

        $planFeature = $this->subscription->plan->features()
            ->where('name', $feature)
            ->first();

        if (! $planFeature) {
            return false;
        }

        return (bool) $planFeature->value;
    }

    public function getRemainingTrialDays(): int
    {
        if (! $this->isOnTrial()) {
            return 0;
        }

        return $this->subscription->trial_ends_at->diffInDays(now());
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function ownerFromMembers()
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

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class)->withoutGlobalScopes();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function customDomains(): HasMany
    {
        return $this->hasMany(CustomDomain::class);
    }

    // Check if user can assign tasks
    public function userCanAssignTasks(User $user): bool
    {
        return $this->members()->where('user_id', $user->id)->whereIn('role', ['owner', 'admin', 'super_admin'])->exists();
    }

    // Alias for members relationship
    public function users()
    {
        return $this->members();
    }

    /** @return HasMany<\App\Models\EmailTemplateTheme, self> */
    public function emailTemplateThemes(): HasMany
    {
        return $this->hasMany(\App\Models\EmailTemplateTheme::class);
    }


    /** @return HasMany<\App\Models\EmailTemplate, self> */
    public function emailTemplates(): HasMany
    {
        return $this->hasMany(\App\Models\EmailTemplate::class);
    }


    /** @return HasMany<\App\Models\Role, self> */
    public function roles(): HasMany
    {
        return $this->hasMany(\App\Models\Role::class);
    }

    /** @return HasMany<\App\Models\File, self> */
    public function files(): HasMany
    {
        return $this->hasMany(\App\Models\File::class);
    }

    /** @return HasMany<\App\Models\Order, self> */
    public function orders(): HasMany
    {
        return $this->hasMany(\App\Models\Order::class);
    }

}
