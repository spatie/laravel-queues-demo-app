<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

final class TimeoutDemoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 7;

    /** @var int */
    public $seconds;

    public function __construct(int $seconds)
    {
        $this->seconds = $seconds;
    }

    public function handle()
    {
        Log::info("start leeping {$this->seconds} seconds");

        sleep($this->seconds);

        Log::info("waking up after sleeping {$this->seconds} seconds");
    }
}
