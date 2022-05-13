<?php

namespace App\Jobs;

use App\Models\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOtpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $otp;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Otp $otp)
    {
        $this->otp=$otp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //send otp section
    }
}
