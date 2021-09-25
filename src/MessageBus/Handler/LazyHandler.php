<?php

namespace Bauhaus\MessageBus\Handler;

use Psr\Container\ContainerInterface as PsrContainer;

/**
 * @internal
 */
class LazyHandler implements Handler
{
    private HandlerParameterType $handlerParameterType;

    public function __construct(
        private PsrContainer $container,
        private string $handlerClassName,
    ) {
        $this->handlerParameterType = new HandlerParameterType($this->handlerClassName);
    }

    public function support(object $incomingMessage): bool
    {
        return $this->handlerParameterType->match($incomingMessage);
    }

    public function execute(object $message): void
    {
        $handler = $this->container->get($this->handlerClassName);

        $handler($message);
    }
}
