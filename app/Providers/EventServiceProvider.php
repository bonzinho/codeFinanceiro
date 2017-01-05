<?php

namespace codeFin\Providers;

use codeFin\Events\BankStoredEvent;
use codeFin\Listeners\BankAccountSetDefaultListener;
use codeFin\listeners\BankLogoUploadListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Repository\Events\RepositoryEntityUpdated;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [  // registo dos eventos e dos repectivos listeners
        BankStoredEvent::class => [
            BankLogoUploadListener::class           
        ],
        RepositoryEntityCreated::class => [
            BankAccountSetDefaultListener::class
        ],
        RepositoryEntityUpdated::class => [
            BankAccountSetDefaultListener::class
        ],
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
