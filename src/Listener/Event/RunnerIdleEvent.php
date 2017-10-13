<?php

namespace Tarantool\JobQueue\Listener;

use Symfony\Component\EventDispatcher\Event;
use Tarantool\Queue\Queue;

class RunnerIdleEvent extends Event
{
    use HasQueue;

    public function __construct(Queue $queue)
    {
        $this->setQueue($queue);
    }
}
