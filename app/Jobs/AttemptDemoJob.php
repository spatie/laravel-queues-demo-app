<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

final class AttemptDemoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var The number of times the job may be attempted */
    public $tries = 4;

    public function handle()
    {
        Log::info("starting attempt {$this->attempts()}");

        sleep(5);

        if ($this->attempts() !== $this->tries) {
            Log::info('Computer says no!');

            throw new Exception("Goodbye!");
        }

        Log::info('Hurray!!');
    }
}
