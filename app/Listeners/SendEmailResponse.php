<?php

namespace App\Listeners;

use App\Events\PermohonanSubmited;
use Illuminate\Support\Facades\Mail;

class SendEmailResponse
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
        $data = $event->data;

        Mail::send("email.response_permohonan_informasi",["code"=>$data->reg_number],function($msg) use ($data){
            $msg->to($data->pengguna_email)->from("noreply@magelangkab.go.id")->subject("Kode tracking");
        });
    }
}
