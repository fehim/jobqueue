<?php

namespace Tarantool\JobQueue\Executor;

use Tarantool\JobQueue\DefaultConfigFactory;
use Tarantool\JobQueue\Handler\Handler;
use Tarantool\Queue\Queue;
use Tarantool\Queue\Task;

return new class extends DefaultConfigFactory
{
    public function createSuccessHandler(): Handler
    {
        return new class (parent::createSuccessHandler()) implements Handler {
            private $handler;

            public function __construct(Handler $handler)
            {
                $this->handler = $handler;
            }

            public function handle(Task $task, Queue $queue)
            {
                $this->handler->handle($task, $queue);

                // do something extra here
            }
        };
    }
};