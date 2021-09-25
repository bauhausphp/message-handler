<?php

namespace Bauhaus\Doubles;

class HandlerWithMultipleParameters
{
    public function __invoke(MessageA $a, MessageB $b): void
    {
    }
}
