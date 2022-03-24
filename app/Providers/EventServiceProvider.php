<?php

namespace App\Providers;

use App\Events\IncidentClosed;
use App\Events\IncidentOpened;
use App\Events\RepairOrderCreated;
use App\Events\RepairOrderStateChanged;
use App\Events\VehicleCreated;
use App\Events\VehicleReassgined;
use App\Events\VehicleStateChanged;
use App\Listeners\SendToAlerts;
use App\Listeners\WriteToFeed;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Mydnic\Kustomer\Events\NewFeedback::class => [
            App\Listeners\SendUserFeedback::class
        ],
        IncidentClosed::class => [
            WriteToFeed::class
        ],
        IncidentOpened::class => [
            WriteToFeed::class,
            SendToAlerts::class,
        ],
        RepairOrderCreated::class => [
            WriteToFeed::class,
            SendToAlerts::class,
        ],
        RepairOrderStateChanged::class => [
            WriteToFeed::class,
            SendToAlerts::class,
        ],
        VehicleCreated::class => [
            WriteToFeed::class,
            SendToAlerts::class,
        ],
        VehicleReassgined::class => [
            WriteToFeed::class,
            SendToAlerts::class,
        ],
        VehicleStateChanged::class => [
            WriteToFeed::class,
            SendToAlerts::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
