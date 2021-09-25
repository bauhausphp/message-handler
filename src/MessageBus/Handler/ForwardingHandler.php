<?php

namespace Bauhaus\MessageBus\Handler;

/**
 * @internal
 */
class ForwardingHandler implements Handler
{
    private HandlerParameterType $handlerParameterType;

    public function __construct(
        private object $actualHandler
    ) {
        $this->handlerParameterType = new HandlerParameterType($this->actualHandler);
    }

    public function support(object $incomingMessage): bool
    {
        return $this->handlerParameterType->match($incomingMessage);
    }

    public function execute(object $message): void
    {
        ($this->actualHandler)($message);
    }
}
