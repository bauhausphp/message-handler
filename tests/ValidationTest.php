<?php

namespace Bauhaus;

use Bauhaus\Doubles\FakePsrContainer;
use Bauhaus\Doubles\HandlerNotCallable;
use Bauhaus\Doubles\HandlerWithMultipleParameters;
use Bauhaus\Doubles\HandlerWithNoParameter;
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
     * @dataProvider notCallableHandlers
     */
    public function throwExceptionIfHandlerIsNotCallable(object|string $hander): void
    {
        $settings = MessageBusSettings::new()
            ->withPsrContainer(new FakePsrContainer([]))
            ->withHandlers($hander);

        $this->expectException(InvalidHandlerProvided::class);

        MessageBus::build($settings);
    }

    /**
     * @test
     */
    public function throwExceptionIfHandlerHasNoParameter(): void
    {
        $settings = MessageBusSettings::new()
            ->withHandlers(new HandlerWithNoParameter());

        $this->expectException(InvalidHandlerProvided::class);

        MessageBus::build($settings);
    }

    /**
     * @test
     */
    public function throwExceptionIfHandlerHasMultipleParameters(): void
    {
        $settings = MessageBusSettings::new()
            ->withHandlers(new HandlerWithMultipleParameters());

        $this->expectException(InvalidHandlerProvided::class);

        MessageBus::build($settings);
    }
}
