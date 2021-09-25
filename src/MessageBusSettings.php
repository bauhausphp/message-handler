<?php

namespace Bauhaus;

use Psr\Container\ContainerInterface as PsrContainer;

class MessageBusSettings
{
    private function __construct(
        private ?PsrContainer $container,
        /** @var string[]|object[] */ private array $handlers,
    ) {
    }

    public static function new(): self
    {
        return new self(null, []);
    }

    public function withPsrContainer(PsrContainer $container): self
    {
        return new self($container, $this->handlers);
    }

    public function withHandlers(string|object ...$handlers): self
    {
        return new self($this->container, $handlers);
    }

    public function psrContainer(): PsrContainer
    {
        return $this->container;
    }

    /**
     * @return string[]|object[]
     */
    public function handlers(): array
    {
        return $this->handlers;
    }
}
