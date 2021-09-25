<?php

namespace Bauhaus\Doubles;

class HandlerForMessageB
{
    public function __construct(
        private HandlerSpy $spy,
    ) {
    }

    public function __invoke(MessageB $message): void
    {
        $this->spy->storeAsCalled($this);
    }
}
