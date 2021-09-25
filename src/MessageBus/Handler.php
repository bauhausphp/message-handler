<?php

namespace Bauhaus\MessageBus;

use ReflectionClass;

class Handler
{
    public function __construct(
        private object $actualHandler
    ) {
    }

    public function support(object $message): bool
    {
        $rClass = new ReflectionClass($this->actualHandler);
        $rParam = $rClass->getMethod('__invoke')->getParameters()[0];

        $supportedMessage = $rParam->getType()->getName();

        return get_class($message) === $supportedMessage;
    }

    public function execute(object $message): void
    {
        $this->actualHandler->__invoke($message);
    }
}
