<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Visualbuilder\EmailTemplates\Facades\TokenHelper;
use Visualbuilder\EmailTemplates\Models\EmailTemplate as BaseEmailTemplate;

class EmailTemplate extends Model
{
    use SoftDeletes;

    protected $table = 'db_email_templates';

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }


    /**
     * @var array
     */
    protected $fillable = [
        'team_id',
        'from',
        'key',
        'name',
        'view',
        'subject',
        'title',
        'preheader',
        'content',
        'language',
        'logo',
        'cc',
        'bcc'

    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'deleted_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'from' => 'array',
        'cc' => 'array',
        'bcc' => 'array',
    ];
    /**
     * @var string[]
     */
    protected $dates = ['deleted_at'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['theme'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTableFromConfig();
        // Include the theme foreign key as a fillable attribute
        $this->fillable[] = config('filament-email-templates.theme_table_name') . '_id';
    }

    /**
     * Remove temporary logo fields before mass assignment.
     */
    public function fill(array $attributes)
    {
        if (isset($attributes['logo_url'])) {
            if (($attributes['logo_type'] ?? null) === 'paste_url' && $attributes['logo_url']) {
                $attributes['logo'] = $attributes['logo_url'];
            }
            unset($attributes['logo_url'], $attributes['logo_type']);
        }

        return parent::fill($attributes);
    }

    protected static function boot()
    {
        parent::boot();

        // When an email template is updated
        static::updated(function ($template) {
            self::clearEmailTemplateCache($template->key, $template->language);
        });

        // When an email template is deleted
        static::deleted(function ($template) {
            self::clearEmailTemplateCache($template->key, $template->language);
        });
    }

    public function setTableFromConfig()
    {
        $this->table = config('filament-email-templates.table_name');
    }

    public static function findEmailByKey($key, $language = null, $teamId = null)
    {
        $teamId = $teamId ?? optional(filament()->getTenant())->id;
        dd($teamId,$language,$key);
        $cacheKey = "email_by_key_{$key}_{$language}_team_{$teamId}";

        //For multi site domains this key will need to include the site_id
        return Cache::remember($cacheKey, now()->addMinutes(60), function () use ($key, $language, $teamId) {
            return self::query()
                ->when($teamId, function (Builder $q) use ($teamId) {
                    $q->where('team_id', $teamId);
                })
                ->language($language ?? config('filament-email-templates.default_locale'))
                ->where("key", $key)
                ->firstOrFail();
        });
    }

    public static function clearEmailTemplateCache($key, $language)
    {
        $teamId = optional(filament()->getTenant())->id;
        $cacheKey = "email_by_key_{$key}_{$language}_team_{$teamId}";
        Cache::forget($cacheKey);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getSendToSelectOptions()
    {
        return collect(config('emailTemplate.recipients'));
    }

    /**
     * @return EmailTemplateFactory
     */
    protected static function newFactory()
    {
        return EmailTemplateFactory::new();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name ?? class_basename($this);
    }

    /**
     * Get the assigned theme or the default
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function theme()
    {
        return $this->belongsTo(EmailTemplateTheme::class, config('filament-email-templates.theme_table_name') . '_id')->withDefault(function ($model) {
            return EmailTemplateTheme::where('is_default', true)->first();
        });
    }

    /**
     * Gets base64 encoded content - to add to an iframe
     *
     * @return string
     */
    public function getBase64EmailPreviewData()
    {
        /**
         * Iframes normally use src attribute to load content from a url
         * This means an extra http request
         *  Below method includes the content directly as base64 encoded
         */

        $data = $this->getEmailPreviewData();
        $content = view($this->view_path, ['data' => $data])->render();

        return base64_encode($content);
    }

    /**
     * @return array
     */
    public function getEmailPreviewData()
    {
        $models = self::createEmailPreviewData();

        return [
            'user' => $models->user,
            'content' => TokenHelper::replace($this->content ?? '', $models),
            'subject' => TokenHelper::replace($this->subject ?? '', $models),
            'preHeaderText' => TokenHelper::replace($this->preheader ?? '', $models),
            'title' => TokenHelper::replace($this->title ?? '', $models),
            'theme' => $this->theme->colours,
            'logo' => $this->logo,
        ];
    }

    /**
     * @return object
     */
    public static function createEmailPreviewData()
    {
        $models = (object)[];

        $userModel = config('filament-email-templates.recipients')[0];
        //Setup some data for previewing email template
        $models->user = $userModel::first();
        $models->tokenUrl = URL::to('/');
        $models->verificationUrl = URL::to('/');
        $models->expiresAt = now();
        /* Not used in preview but need to add something */
        $models->plainText = Str::random(32);

        return $models;
    }

    /**
     * Efficient method to return requested template locale or default language template in one query
     *
     * @param Builder $query
     * @param $language
     *
     * @return Builder
     */
    #[Scope]
    public function language(Builder $query, $language)
    {
        $languages = [$language, config('filament-email-templates.default_locale')];

        return $query->whereIn('language', $languages)
            ->orderByRaw(
                "(CASE WHEN language = ? THEN 1 ELSE 2 END)",
                [$language]
            );
    }

    /**
     * @return Attribute
     */
    public function viewPath(): Attribute
    {
        return new Attribute(
            get: fn() => config('filament-email-templates.template_view_path') . '.' . $this->view
        );
    }

    /**
     * @return bool
     */
    public function getMailableExistsAttribute(): bool
    {
        $className = Str::studly($this->key);
        $filePath = app_path(config('filament-email-templates.mailable_directory') . "/{$className}.php");

        return File::exists($filePath);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getMailableClass()
    {
        $className = Str::studly($this->key);
        $directory = str_replace('/', '\\', config('filament-email-templates.mailable_directory', 'Mail/Visualbuilder/EmailTemplates'));
        $fullClassName = "App\\" . rtrim($directory, '\\') . "\\{$className}";

        if (!class_exists($fullClassName)) {
            throw new \Exception("Mailable class {$fullClassName} does not exist.");
        }

        return $fullClassName;
    }


    public function getLogoAttribute(): string
    {
        //Get Database logo or config logo
        $logo = $this->attributes['logo'] ?? config('filament-email-templates.logo');

        // Return the logo if it's a full URL, otherwise, return the asset URL.
        return Str::isUrl($logo) ? $logo : asset($logo);
    }
}


