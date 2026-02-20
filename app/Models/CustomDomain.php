<?php

namespace App\Models;

use App\Services\CustomDomainService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class CustomDomain extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'domain',
        'is_verified',
        'is_primary',
        'dns_verification_token',
        'verified_at',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_primary' => 'boolean',
        'verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::saved(function ($customDomain) {
            // Clear related caches
            Cache::forget("custom_domain_{$customDomain->domain}");
            if ($customDomain->team) {
                Cache::forget("tenant_primary_domain_{$customDomain->team->id}");
                Cache::forget("tenant_domains_{$customDomain->team->id}");
            }
        });

        static::deleted(function ($customDomain) {
            // Clear related caches
            Cache::forget("custom_domain_{$customDomain->domain}");
            if ($customDomain->team) {
                Cache::forget("tenant_primary_domain_{$customDomain->team->id}");
                Cache::forget("tenant_domains_{$customDomain->team->id}");
            }
        });
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function getFullUrlAttribute(): string
    {
        return "https://{$this->domain}.".request()->getHost();
    }

    public function generateDnsVerificationToken(): string
    {
        $token = str()->random(32);
        $this->update(['dns_verification_token' => $token]);
        return $token;
    }

    public function getDnsVerificationRecord(): array
    {
        return [
            'type' => 'TXT',
            'name' => '_custom-domain-verify.' . $this->domain,
            'value' => $this->dns_verification_token,
            'ttl' => 300,
        ];
    }

    public function getCnameRecord(): array
    {
        return [
            'type' => 'CNAME',
            'name' => $this->domain,
            'value' => config('app.url_host', 'your-app-domain.com'),
            'ttl' => 3600,
        ];
    }
}
