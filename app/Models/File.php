<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'filename',
        'original_name',
        'path',
        'size',
        'mime_type',
        'fileable_type',
        'fileable_id',
        'uploaded_by',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function fileable(): BelongsTo
    {
        return $this->morphTo();
    }

    // Helper method to get size in GB
    public function getSizeGbAttribute(): float
    {
        return $this->size / (1024 * 1024 * 1024); // Convert bytes to GB
    }

    // Helper method to get size in MB
    public function getSizeMbAttribute(): float
    {
        return $this->size / (1024 * 1024); // Convert bytes to MB
    }

    // Scope for team files
    public function scopeForTeam($query, $teamId)
    {
        return $query->where('team_id', $teamId);
    }

    // Scope for specific fileable type
    public function scopeForFileable($query, $fileableType, $fileableId)
    {
        return $query->where('fileable_type', $fileableType)
                    ->where('fileable_id', $fileableId);
    }
}
