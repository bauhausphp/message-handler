<?php

namespace Bauhaus;

use Bauhaus\MessageBus\Handler;

class MessageBus
{
    public function __construct(
        /** @var Handler[] */ private array $handlers,
    ) {
    }

    public static function build(MessageBusSettings $settings): self
    {
        $handlers = array_map(
            fn (object $h): Handler => new Handler($h),
            $settings->handlers(),
        );

        return new self($handlers);
    }

    public function dispatch(object $message): void
    {
        $this
            ->findHandlerByMessage($message)
            ->execute($message);
    }

    public function findHandlerByMessage(object $message): Handler
    {
        $filtered = array_filter(
            $this->handlers,
            fn (Handler $h): bool => $h->support($message),
        );

        return array_pop($filtered);
    }
}
