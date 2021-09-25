<?php

namespace Bauhaus\MessageBus;

use Bauhaus\MessageBus\Handler\Handler;

/**
 * @internal
 */
class HandlerCollection
{
    public function __construct(
        /** @var Handler[] */ private array $handlers,
    ) {
    }

    public function findHandlerByMessage(object $message): Handler
    {
        $matchingHandlers = array_filter(
            $this->handlers,
            fn (Handler $h): bool => $h->support($message),
        );

        // TODO check if count !== 1

        return array_pop($matchingHandlers);
    }
}
