<?php

namespace App\Providers;

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
        
        // Saga Events
        \App\Services\Saga\Events\SagaStepCompleted::class => [
            \App\Listeners\OrderProcessingListener::class . '@handleSagaStepCompleted',
        ],
        \App\Services\Saga\Events\SagaStepFailed::class => [
            \App\Listeners\OrderProcessingListener::class . '@handleSagaStepFailed',
        ],
        
        // Order Processing Events
        \App\Events\OrderProcessingStarted::class => [
            \App\Listeners\OrderProcessingListener::class . '@handleOrderProcessingStarted',
        ],
        \App\Events\OrderProcessingCompleted::class => [
            \App\Listeners\OrderProcessingListener::class . '@handleOrderProcessingCompleted',
        ],
        \App\Events\OrderProcessingFailed::class => [
            \App\Listeners\OrderProcessingListener::class . '@handleOrderProcessingFailed',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
