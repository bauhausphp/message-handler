<?php

namespace Bauhaus;

use Bauhaus\MessageBus\Handler;

class MessageBusSettings
{
    private function __construct(
        private array $handlers,
    ) {
    }

    public static function new(): self
    {
        return new self([]);
    }

    public function withHandlers(object ...$handlers): self
    {
        return new self($handlers);
    }

    /**
     * @return object[]
     */
    public function handlers(): array
    {
        return $this->handlers;
    }
}
