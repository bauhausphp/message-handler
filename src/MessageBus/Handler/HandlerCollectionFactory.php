<?php

namespace Bauhaus\MessageBus\Handler;

use Bauhaus\MessageBusSettings;

/**
 * @internal
 */
class HandlerCollectionFactory
{
    public function __construct(
        private MessageBusSettings $settings,
    ) {
    }

    public static function build(MessageBusSettings $settings): HandlerCollection
    {
        $factory = new self($settings);

        return new HandlerCollection($factory->mapHandlersToInternalObjects());
    }

    /**
     * @return Handler[]
     */
    private function mapHandlersToInternalObjects(): array
    {
        return array_map(
            fn (object|string $h): Handler => $this->createHandler($h),
            $this->settings->handlers(),
        );
    }

    private function createHandler(object|string $actualHandler): Handler
    {
        return match (is_object($actualHandler)) {
            true => new ForwardingHandler($actualHandler),
            false => new LazyHandler($this->settings->psrContainer(), $actualHandler),
        };
    }
}
