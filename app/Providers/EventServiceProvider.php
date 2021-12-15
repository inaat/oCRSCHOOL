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
        \App\Events\FeeTransactionPaymentAdded::class => [
            \App\Listeners\AddAccountTransaction::class,
        ],
        
        \App\Events\FeeTransactionPaymentUpdated::class => [
            \App\Listeners\UpdateAccountTransaction::class,
        ], 
        \App\Events\FeeTransactionPaymentDeleted::class => [
            \App\Listeners\DeleteAccountTransaction::class,
        ],

        //Hrm
        \App\Events\HrmTransactionPaymentAdded::class => [
            \App\Listeners\HrmAddAccountTransaction::class,
        ],
        
        \App\Events\HrmTransactionPaymentUpdated::class => [
            \App\Listeners\HrmUpdateAccountTransaction::class,
        ], 
        \App\Events\HrmTransactionPaymentDeleted::class => [
            \App\Listeners\HrmDeleteAccountTransaction::class,
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
