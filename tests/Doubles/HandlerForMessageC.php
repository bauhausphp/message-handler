<?php

namespace Bauhaus\Doubles;

class HandlerForMessageC
{
    public function __construct(
        private HandlerSpy $spy,
    ) {
    }

    public function __invoke(MessageC $message): void
    {
        $this->spy->storeAsCalled($this);
    }
}
