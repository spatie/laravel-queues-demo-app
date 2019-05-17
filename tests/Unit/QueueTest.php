<?php

namespace Tests\Unit;

use App\Jobs\SleepJob;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class QueueTest extends TestCase
{
    /** @test */
    public function it_will_push_something_to_the_queue()
    {
        Queue::fake();

        $this->get(101);

        Queue::assertPushed(SleepJob::class, function(SleepJob $job) {
            $this->assertEquals(3, $job->seconds);

            return true;
        });
    }
}
