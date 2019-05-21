<?php

namespace App\Events;

use App\Models\PermohonanInformasi;
use Illuminate\Support\Facades\Log;

class PermohonanSubmited extends Event
{
    private $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PermohonanInformasi $data)
    {
        $this->data = $data;
        Log::debug("Permohonan id created: ".$this->data->id);
    }
}
