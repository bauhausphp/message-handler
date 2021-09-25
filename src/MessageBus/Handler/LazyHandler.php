<?php

namespace Bauhaus\MessageBus\Handler;

use Psr\Container\ContainerInterface as PsrContainer;

/**
 * @internal
 */
class LazyHandler implements Handler
{
    public function __construct(
        private PsrContainer $container,
        private string $handlerId,
    ) {
    }

    public function support(object $incomingMessage): bool
    {
        $handlerParameterType = new HandlerParameterType($this->handlerId);

        return $handlerParameterType->match($incomingMessage);
    }

    public function execute(object $message): void
    {
        $handler = $this->container->get($this->handlerId);

        $handler($message);
    }
}
