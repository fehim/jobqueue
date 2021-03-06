<?php

namespace Tarantool\JobQueue\Tests\Unit\Executor\CallbackResolver;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Tarantool\JobQueue\Executor\CallbackResolver\Psr11ContainerCallbackResolver;
use Tarantool\JobQueue\JobOptions;

class Psr11ContainerCallbackResolverTest extends TestCase
{
    /**
     * @dataProvider provideResolveData
     */
    public function testResolve(string $serviceName, string $id, string $idFormat = null): void
    {
        $callback = function ($payload) {};
        $payload = [JobOptions::PAYLOAD_SERVICE => $serviceName];

        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->atLeastOnce())->method('get')
            ->with($id)
            ->willReturn($callback);

        $executor = null !== $idFormat
            ? new Psr11ContainerCallbackResolver($container, $idFormat)
            : new Psr11ContainerCallbackResolver($container);

        $this->assertSame($callback, $executor->resolve($payload));
    }

    public function provideResolveData(): iterable
    {
        return [
            ['foobar', 'foobar'],
            ['foobar', 'foobar', '%s'],
            ['foobar', 'job.foobar', 'job.%s'],
            ['foobar', 'foobar.job', '%s.job'],
            ['foobar', 'jobqueue.foobar.job', 'jobqueue.%s.job'],
        ];
    }

    /**
     * @expectedException \Tarantool\JobQueue\Exception\BadPayloadException
     */
    public function testResolveInvalidPayload(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $executor = new Psr11ContainerCallbackResolver($container);

        $executor->resolve(['invalid_key' => 'foobar']);
    }
}
