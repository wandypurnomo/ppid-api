<?php

namespace App\Listeners\Permohonan;

use App\Events\PermohonanSubmited;
use App\Models\StatusLog;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Providers\Auth\Sentinel;

class WriteLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PermohonanSubmited  $event
     * @return void
     */
    public function handle(PermohonanSubmited $event)
    {
        $permohonan = $event->data;
        Log::info($permohonan->id);
        $data = [
            "permohonan_id" => $permohonan->id,
            "status" => "PERMOHONAN TERKIRIM",
            "created_by" => 0
        ];

        (new StatusLog())->newQuery()->create($data);
    }
}
