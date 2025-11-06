<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Usage extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'subscription_id',
        'plan_feature_id',
        'usageable_type',
        'usageable_id',
        'metric_name',
        'quantity',
        'unit_price',
        'total_amount',
        'billing_period_start',
        'billing_period_end',
        'recorded_at',
        'metadata',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'unit_price' => 'decimal:4',
        'total_amount' => 'decimal:2',
        'billing_period_start' => 'datetime',
        'billing_period_end' => 'datetime',
        'recorded_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function planFeature(): BelongsTo
    {
        return $this->belongsTo(PlanFeature::class);
    }

    public function usageable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope to get usage for a specific billing period
     */
    #[Scope]
    public function forBillingPeriod($query, $start, $end)
    {
        return $query->whereBetween('billing_period_start', [$start, $end])
            ->orWhereBetween('billing_period_end', [$start, $end]);
    }

    /**
     * Scope to get usage for a specific metric
     */
    public function scopeForMetric($query, $metricName)
    {
        return $query->where('metric_name', $metricName);
    }

    /**
     * Scope to get usage for a specific team
     */
    public function scopeForTeam($query, $teamId)
    {
        return $query->where('team_id', $teamId);
    }

    /**
     * Calculate total usage amount for a team in a billing period
     */
    public static function getTotalUsageForTeam($teamId, $start, $end)
    {
        return static::forTeam($teamId)
            ->forBillingPeriod($start, $end)
            ->sum('total_amount');
    }

    /**
     * Get usage summary for a team
     */
    public static function getUsageSummary($teamId, $start, $end)
    {
        return static::forTeam($teamId)
            ->forBillingPeriod($start, $end)
            ->selectRaw('metric_name, SUM(quantity) as total_quantity, SUM(total_amount) as total_amount')
            ->groupBy('metric_name')
            ->get();
    }
}
