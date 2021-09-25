<?php

namespace Bauhaus\MessageBus\Handler;

/**
 * @internal
 */
class SimpleHandler extends AbstractHandler
{
    public function __construct(
        private object $actualHandler
    ) {
        parent::__construct($this->actualHandler);
    }

    protected function loadHandler(): object
    {
        return $this->actualHandler;
    }
}
