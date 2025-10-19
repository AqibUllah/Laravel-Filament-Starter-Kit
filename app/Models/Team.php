<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
