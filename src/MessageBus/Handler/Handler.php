<?php

namespace Bauhaus\MessageBus\Handler;

/**
 * @internal
 */
interface Handler
{
    public function support(object $incomingMessage): bool;
    public function execute(object $incomingMessage): void;
}
