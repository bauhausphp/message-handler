<?php

namespace Bauhaus\MessageBus\Handler;

/**
 * @internal
 */
class ForwardingHandler implements Handler
{
    public function __construct(
        private object $actualHandler
    ) {
    }

    public function support(object $incomingMessage): bool
    {
        $handlerParameterType = new HandlerParameterType($this->actualHandler);

        return $handlerParameterType->match($incomingMessage);
    }

    public function execute(object $message): void
    {
        ($this->actualHandler)($message);
    }
}
