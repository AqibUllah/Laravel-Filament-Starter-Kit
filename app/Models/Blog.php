<?php

namespace App\Models;

use App\Enums\BlogStatusEnum;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'user_id',
        'title',
        'slug',
        'featured_image',
        'excerpt',
        'content',
        'published_at',
        'status',
    ];

    protected $casts = [
        'status' => BlogStatusEnum::class,
        'published_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($blog) {
            $blog->team_id = Filament::getTenant()->id;
            $blog->user_id = auth()->id();
        });

        static::saving(function ($blog) {

            if ($blog->status === BlogStatusEnum::Published && ! $blog->published_at) {
                $blog->published_at = now();
            }

            if ($blog->status === BlogStatusEnum::Scheduled && $blog->published_at?->isPast()) {
                $blog->status = BlogStatusEnum::Published;
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

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'timestamp',
        ];
    }
}
