<?php

namespace Bauhaus;

use Bauhaus\MessageBus\HandlerCollection;
use Bauhaus\MessageBus\HandlerCollectionFactory;

class MessageBus
{
    public function __construct(
        private HandlerCollection $handlers,
    ) {
    }

    public static function build(MessageBusSettings $settings): self
    {
        return new self(HandlerCollectionFactory::build($settings));
    }

    public function dispatch(object $message): void
    {
        $this->handlers
            ->findHandlerByMessage($message)
            ->execute($message);
    }
}
