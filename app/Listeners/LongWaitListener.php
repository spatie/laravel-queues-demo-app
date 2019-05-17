<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Horizon\Events\LongWaitDetected;
use Log;

class LongWaitListener
{
    public function handle(LongWaitDetected $event)
    {
        Log::info("A wait of {$event->seconds} seconds was detected on {$event->queue}");
    }
}
