<?php

namespace Bauhaus;

use Psr\Container\ContainerInterface as PsrContainer;

class MessageBusSettings
{
    private function __construct(
        public readonly ?PsrContainer $psrContainer,
        /** @var string[]|object[] */ public readonly array $handlers,
    ) {
    }

    public static function new(): self
    {
        return new self(null, []);
    }

    public function withPsrContainer(PsrContainer $psrContainer): self
    {
        return new self($psrContainer, $this->handlers);
    }

    public function withHandlers(string|object ...$handlers): self
    {
        return new self($this->psrContainer, $handlers);
    }
}
