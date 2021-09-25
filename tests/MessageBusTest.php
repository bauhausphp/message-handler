<?php

namespace Bauhaus;

use Bauhaus\Doubles\FakePsrContainer;
use Bauhaus\Doubles\HandlerForMessageA;
use Bauhaus\Doubles\HandlerForMessageB;
use Bauhaus\Doubles\HandlerForMessageC;
use Bauhaus\Doubles\HandlerSpy;
use Bauhaus\Doubles\MessageA;
use Bauhaus\Doubles\MessageB;
use Bauhaus\Doubles\MessageC;
use PHPUnit\Framework\TestCase;

class MessageBusTest extends TestCase
{
    private MessageBus $bus;
    private HandlerSpy $handlerSpy;

    protected function setUp(): void
    {
        $this->handlerSpy = new HandlerSpy();

        $settings = MessageBusSettings::new()
            ->withPsrContainer(new FakePsrContainer([
                HandlerForMessageB::class => new HandlerForMessageB($this->handlerSpy),
                HandlerForMessageC::class => new HandlerForMessageC($this->handlerSpy),
            ]))
            ->withHandlers(
                new HandlerForMessageA($this->handlerSpy),
                HandlerForMessageB::class,
                HandlerForMessageC::class,
            );

        $this->bus = MessageBus::build($settings);
    }

    public function messagesWithExpectedHandler(): array
    {
        return [
            [new MessageA(), HandlerForMessageA::class],
            [new MessageB(), HandlerForMessageB::class],
            [new MessageC(), HandlerForMessageC::class],
        ];
    }

    /**
     * @test
     * @dataProvider messagesWithExpectedHandler
     */
    public function callCorrectHandler(object $message, string $expectedHandler): void
    {
        $this->bus->dispatch($message);

        $this->assertHandlerAsCalled($expectedHandler);
    }

    private function assertHandlerAsCalled(string $expected): void
    {
        $this->assertInstanceOf($expected, $this->handlerSpy->calledHandler());
    }
}
