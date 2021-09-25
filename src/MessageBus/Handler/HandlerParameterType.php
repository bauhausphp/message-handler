<?php

namespace Bauhaus\MessageBus\Handler;

use ReflectionException;
use ReflectionMethod;
use ReflectionParameter;

/**
 * @internal
 */
class HandlerParameterType
{
    private const TARGET_METHOD = '__invoke';

    private ReflectionParameter $handlerParameter;

    public function __construct(
        private object|string $handler,
    ) {
        try {
            $rMethod = new ReflectionMethod($this->handler, self::TARGET_METHOD);
        } catch (ReflectionException) {
            throw new InvalidHandlerProvided();
        }

        if ($rMethod->getNumberOfParameters() !== 1) {
            throw new InvalidHandlerProvided();
        }

        $this->handlerParameter = $rMethod->getParameters()[0];
    }

    public function match(object $incomingMessage): string
    {
        $supportedType = $this->handlerParameter->getType()->getName();
        $incomingType = get_class($incomingMessage);

        return $incomingType === $supportedType;
    }
}
