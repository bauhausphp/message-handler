<?php

namespace Bauhaus\MessageBus\Handler;

use ReflectionClass;

/**
 * @internal
 */
class HandlerParameterType
{
    public function __construct(
        private object|string $handler,
    ) {
    }

    public function match(object $incomingMessage): string
    {
        $supportedType = $this->extractParameterType();
        $incomingType = get_class($incomingMessage) ;

        return $incomingType === $supportedType;
    }

    private function extractParameterType(): string
    {
        $rClass = new ReflectionClass($this->handler);
        $rParam = $rClass->getMethod('__invoke')->getParameters()[0];

        // TODO check if there is only on parameter

        return $rParam->getType()->getName();
    }
}
