<?php

namespace Tarantool\JobQueue\Executor;

use Symfony\Component\Process\Process;
use Tarantool\JobQueue\Exception\BadPayloadException;
use Tarantool\Queue\Queue;

class ProcessExecutor implements Executor
{
    public function execute($payload, Queue $queue): void
    {
        $process = $this->createProcess($payload);
        $process->mustRun();
    }

    private function createProcess($payload): Process
    {
        if ($payload instanceof Process) {
            return $payload;
        }

        if (is_string($payload)) {
            return new Process($payload);
        }

        throw BadPayloadException::unexpectedType($payload, 'string or '.Process::class, __CLASS__);
    }
}
