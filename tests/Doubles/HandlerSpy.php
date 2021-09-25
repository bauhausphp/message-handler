<?php

namespace Bauhaus\Doubles;

class HandlerSpy
{
    private ?object $calledHandler = null;

    public function storeAsCalled(object $handler): void
    {
        $this->calledHandler = $handler;
    }

    public function calledHandler(): ?object
    {
        return $this->calledHandler;
    }
}
