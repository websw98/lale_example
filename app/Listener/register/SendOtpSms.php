<?php

namespace App\Listener\register;

use App\Events\auth\RegisterWithSms;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOtpSms
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
     * @param  \App\Events\auth\RegisterWithSms  $event
     * @return void
     */
    public function handle(RegisterWithSms $event)
    {
        //
    }
}
