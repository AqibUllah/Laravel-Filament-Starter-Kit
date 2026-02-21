<?php

namespace App\Providers;

use App\Events\OrderCancelled;
use App\Events\OrderPaid;
use App\Events\OrderShipped;
use App\Events\ProjectCreated;
use App\Events\TaskAssigned;
use App\Events\TeamInvitation;
use App\Listeners\SendOrderCancelledNotification;
use App\Listeners\SendOrderPaidNotification;
use App\Listeners\SendOrderShippedNotification;
use App\Listeners\SendProjectCreatedNotification;
use App\Listeners\SendTaskAssignedNotification;
use App\Listeners\SendTeamInvitationNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ProjectCreated::class => [
            SendProjectCreatedNotification::class,
        ],
        TaskAssigned::class => [
            SendTaskAssignedNotification::class,
        ],
        TeamInvitation::class => [
            SendTeamInvitationNotification::class,
        ],
        OrderPaid::class => [
            SendOrderPaidNotification::class,
        ],
        OrderShipped::class => [
            SendOrderShippedNotification::class,
        ],
        OrderCancelled::class => [
            SendOrderCancelledNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
