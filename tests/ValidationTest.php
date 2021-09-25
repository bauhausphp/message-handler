<?php

namespace Bauhaus;

use Bauhaus\Doubles\FakePsrContainer;
use Bauhaus\Doubles\HandlerNotCallable;
use Bauhaus\MessageBus\Handler\InvalidHandlerProvided;
use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase
{
    public function notCallableHandlers(): array
    {
        return [
            'object' => [new HandlerNotCallable()],
            'string class name' => [HandlerNotCallable::class],
        ];
    }

    /**
     * @test
     * 2@dataProvider notCallableHandlers
     */
    public function throwExceptionIfHandlerIsNotCallable(object|string $hander): void
    {
        $settings = MessageBusSettings::new()
            ->withPsrContainer(new FakePsrContainer([]))
            ->withHandlers($hander);

        $this->expectException(InvalidHandlerProvided::class);

        MessageBus::build($settings);
    }
}
