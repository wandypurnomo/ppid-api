<?php

namespace App\Providers;

use App\Events\PermohonanSubmited;
use App\Listeners\Permohonan\WriteLog;
use App\Listeners\SendEmailResponse;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        PermohonanSubmited::class => [
            SendEmailResponse::class,
            WriteLog::class
        ]
    ];
}
