<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'name',
        'value',
        'sort_order',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function getValueAttribute($value)
    {
        if (is_numeric($value)) {
            return (int) $value;
        } elseif (in_array($value, ['true', 'false'])) {
            return $value === 'true';
        }

        return $value;
    }
}
