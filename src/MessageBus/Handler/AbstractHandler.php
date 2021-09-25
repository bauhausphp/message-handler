<?php

namespace Bauhaus\MessageBus\Handler;

/**
 * @internal
 */
abstract class AbstractHandler implements Handler
{
    private HandlerParameterType $handlerParameterType;

    public function __construct(
        private object|string $handler,
    ) {
        $this->handlerParameterType = new HandlerParameterType($this->handler);
    }

    public function support(object $incomingMessage): bool
    {
        return $this->handlerParameterType->match($incomingMessage);
    }

    public function execute(object $message): ?object
    {
        return ($this->loadHandler())($message);
    }

    abstract protected function loadHandler(): object;
}
