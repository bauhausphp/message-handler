<?php

namespace Bauhaus\MessageBus\Handler;

use Psr\Container\ContainerInterface as PsrContainer;

/**
 * @internal
 */
class LazyHandler extends AbstractHandler
{
    public function __construct(
        private PsrContainer $container,
        private string $handlerClassName,
    ) {
        parent::__construct($this->handlerClassName);
    }

    protected function loadHandler(): object
    {
        return $this->container->get($this->handlerClassName);
    }
}
