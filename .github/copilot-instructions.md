# Copilot Instructions for Laravel Filament SaaS Starter Kit

## Architecture Overview

### Multi-Tenancy: Team-Based Model
- **Primary Tenant Model**: `App\Models\Team` (stored in `team_id` columns)
- **User-Team Relationship**: Users can belong to multiple teams via `team_user` pivot table
- **Tenant Context**: Always accessed via `filament()->getTenant()` in Filament contexts
- **Data Isolation**: Use `TenantSettingsRepository` which auto-scopes queries to `tenant_id`
- **Global Models**: `Plan`, `PlanFeature` use `PlanWithoutTenantScope` to bypass tenant filtering

### Tenant-Scoped Settings Pattern
- Settings use Spatie Laravel Settings with custom `TenantSettingsRepository`
- Settings are scoped to `tenant_id` in the database (see `app/Settings/TenantGeneralSettings.php`)
- Access via: `app(TenantGeneralSettings::class)->property_name`
- Automatic tenant context detection from `filament()->getTenant()`, auth user, or URL

### Core Models & Relationships
- **User**: Implements Filament authentication contracts, has roles/permissions per team
- **Team**: Owner-based, contains projects, tasks, and subscription data
- **Task/Project**: Scoped to teams automatically via settings repository
- **Subscription/Plan**: Team subscriptions tied to Stripe, coupon support built-in

## Development Workflows

### Setup
```bash
composer run setup              # Install, generate key, migrate, seed
```

### Daily Development
```bash
composer run dev                # Run Laravel server, queue, pail, and Vite concurrently
npm run build                   # Production frontend build
npm run dev                      # Frontend hot-reload (via Vite)
```

### Testing
```bash
composer run test               # Run Pest tests (automatically refreshes DB)
```

### Database
- Migrations: `database/migrations/` (timestamped, include team_id for tenant models)
- Settings migrations: `database/settings/` (use `TenantSettingsRepository` for scoping)
- Seed with: `php artisan db:seed`
- Settings: Use `php artisan tinker` with `app(TenantGeneralSettings::class)` to inspect

## Filament & UI Patterns

### Resource Organization
- **Admin Panel**: `app/Filament/Admin/` (site-wide settings, admin users)
- **Tenant Panel**: `app/Filament/Tenant/` (team workspaces, team-scoped data)
- **Resource Structure**: Separate `Tables/` and `Forms/` classes (e.g., `Blogs/BlogsTable.php`)
- **Forms/Tables**: Use static methods returning configured instances for reusability

### Tenant Registration & Settings
- New teams: `app/Filament/Tenant/Pages/Tenancy/RegisterTeam.php` creates default settings
- Team settings page: `ManageTenantSettings.php` uses Filament Forms with sections
- Settings initialize from `TenantGeneralSettings` class properties

### Middleware & Scoping
- `SyncShieldTenant`: Syncs roles/permissions to team scope (Filament Shield)
- `RedirectIfUserNotSubscribedMiddleware`: Blocks access if no active subscription
- `RecordUsageMiddleware`: Tracks usage for billing/feature limiting

## Key External Integrations

### Stripe Billing
- Provider: `StripeBillingProvider` handles checkout, subscriptions
- Models: `Subscription`, `Plan`, `PlanFeature`, `Coupon`
- Config: `config/filament-shield.php`, billing setup in `TenantPanelProvider`

### Roles & Permissions
- **Package**: Spatie Laravel Permission with Filament Shield
- **Tenancy**: Scoped to teams (`ScopeToTenant()` in Shield config)
- **Generate Roles**: `php artisan shield:generate --panel=tenant --option=permissions --all`

### Email & Notifications
- Email templates: `VisualBuilder` (namespaced as `emailtemplates`)
- Logs: Filament Laravel Log plugin integrated into Settings navigation

## Code Conventions

### Method Return Types & Constructor Property Promotion
```php
// Always explicit return types
public function getUserTeams(User $user): Collection { ... }

// Use PHP 8 constructor property promotion
public function __construct(public GitHub $github) { }
```

### Tenant Context Access Pattern
```php
// Filament context (preferred in resources, pages, policies)
$tenant = filament()->getTenant();

// Repository pattern (in services)
$tenantId = $this->currentTenantId(); // TenantSettingsRepository method

// Direct model scoping
Task::where('team_id', $tenantId)->get();
```

### Global Query Scopes vs Without Scopes
```php
// Auto-scoped by default in TenantSettingsRepository
Task::all(); // Filtered by current tenant

// Bypass tenant scope (for global models like Plan)
Plan::withoutGlobalScopes()->get();
```

## Debugging & Tools

### Access Filament Context
- Current tenant: `filament()->getTenant()`
- User: `auth()->user()`
- Current user's teams: `auth()->user()->teams`
- Settings: `app(TenantGeneralSettings::class)`

### Common Debug Points
- Settings not loading? Check `TenantSettingsRepository::currentTenantId()` priority
- Permissions not applying? Verify role is synced to team in `SyncShieldTenant` middleware
- Frontend changes not showing? Run `npm run build` or `npm run dev`

### Database Queries
- Tenant-scoped settings migrations auto-create defaults in `InitializeDefaultSettingsForTenant`
- Use `DB::table('settings')->where('group', 'tenant_general')->get()` to inspect

## Common Tasks

### Add a New Team-Scoped Feature
1. Create model in `app/Models/` with `team_id` column
2. Add migration with `->foreignId('team_id')->constrained('teams')`
3. Create Filament Resource in `app/Filament/Tenant/Resources/`
4. Register Resource in `TenantPanelProvider`

### Add Team Settings
1. Add property to `app/Settings/TenantGeneralSettings.php`
2. Create settings migration in `database/settings/`
3. Add form fields in `ManageTenantSettings.php`
4. Access via `app(TenantGeneralSettings::class)->property_name`

### Create a Service Layer Component
1. Place in `app/Services/` with constructor injection
2. Type-hint dependencies (use container auto-wiring)
3. Return value objects or models, avoid side-effects in getters
