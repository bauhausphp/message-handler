<?php

namespace Bauhaus\Doubles;

class HandlerForMessageA
{
    public function __construct(
        private HandlerSpy $spy,
    ) {
    }

    public function __invoke(MessageA $message): void
    {
        $this->spy->storeAsCalled($this);
    }
}
