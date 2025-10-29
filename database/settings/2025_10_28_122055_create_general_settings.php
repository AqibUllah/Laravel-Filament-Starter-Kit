<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'Spatie');
        $this->migrator->add('general.site_active', true);
        $this->migrator->add('general.site_email', 'info@spatie.be');
        $this->migrator->add('general.site_phone', '+32 475 00 00 00');
        $this->migrator->add('general.site_address', '123 Main St, Anytown, USA');
        $this->migrator->add('general.site_city', 'Anytown');
        $this->migrator->add('general.site_state', 'CA');
        $this->migrator->add('general.site_zip', '12345');
        $this->migrator->add('general.site_country', 'USA');
        $this->migrator->add('general.site_logo', 'https://spatie.be/logo.png');
        $this->migrator->add('general.site_favicon', 'https://spatie.be/favicon.ico');
        $this->migrator->add('general.site_description', 'Spatie is a software development company that specializes in building web applications.');
        $this->migrator->add('general.site_keywords', 'spatie, software development, web applications');
        $this->migrator->add('general.site_author', 'Spatie');
        $this->migrator->add('general.site_copyright', 'Copyright © 2025 Spatie');
        $this->migrator->add('general.site_analytics', 'UA-123456789-1');
        $this->migrator->add('general.site_analytics_code', 'UA-123456789-1');
    }
};
