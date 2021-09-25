<?php

namespace Bauhaus\Doubles;

use Psr\Container\ContainerInterface as PsrContainer;

class FakePsrContainer implements PsrContainer
{
    public function __construct(
        /** @var object[] */ private array $handlers,
    ) {
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->handlers);
    }

    public function get(string $id): object
    {
        return $this->handlers[$id];
    }
}
