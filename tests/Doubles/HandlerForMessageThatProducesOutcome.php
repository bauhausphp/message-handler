<?php

namespace Bauhaus\Doubles;

class HandlerForMessageThatProducesOutcome
{
    public function __construct(
        private HandlerSpy $spy,
    ) {
    }

    public function __invoke(MessageThatProducesOutcome $message): object
    {
        $this->spy->storeAsCalled($this);

        return new Outcome();
    }
}
