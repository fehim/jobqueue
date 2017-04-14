<?php

namespace Tarantool\JobQueue\Executor\CallbackResolver;

use Psr\Container\ContainerInterface as Container;
use Tarantool\JobQueue\Exception\BadPayloadException;

class ContainerCallbackResolver implements CallbackResolver
{
    private $container;
    private $idPrefix;

    public function __construct(Container $container, string $idPrefix = '')
    {
        $this->container = $container;
        $this->idPrefix = $idPrefix;
    }

    public function resolve($payload): callable
    {
        if (!empty($payload['service'])) {
            return $this->container->get($this->idPrefix.$payload['service']);
        }

        throw BadPayloadException::missingOrEmptyKeyValue($payload, 'service', 'string', __CLASS__);
    }
}