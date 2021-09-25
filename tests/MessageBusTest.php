<?php

namespace Bauhaus;

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
            ->withHandlers(
                new HandlerForMessageA($this->handlerSpy),
                new HandlerForMessageB($this->handlerSpy),
                new HandlerForMessageC($this->handlerSpy),
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
