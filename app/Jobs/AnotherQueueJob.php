<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

final class AnotherQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var int */
    public $seconds;

    public function __construct(int $seconds = 1)
    {
        $this->seconds = $seconds;

        $this->queue = 'another queue';
    }

    public function handle()
    {
        Log::info('processing video');

        sleep($this->seconds);

        Log::info("waking up after sleeping {$this->seconds} seconds");
    }
}
