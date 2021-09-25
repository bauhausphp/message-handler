<?php

namespace Bauhaus;

use Bauhaus\Doubles\FakePsrContainer;
use Bauhaus\Doubles\HandlerForMessageA;
use Bauhaus\Doubles\HandlerForMessageB;
use Bauhaus\Doubles\HandlerForMessageC;
use Bauhaus\Doubles\HandlerForMessageThatProducesOutcome;
use Bauhaus\Doubles\HandlerSpy;
use Bauhaus\Doubles\MessageA;
use Bauhaus\Doubles\MessageB;
use Bauhaus\Doubles\MessageC;
use Bauhaus\Doubles\MessageThatProducesOutcome;
use Bauhaus\Doubles\Outcome;
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
                new HandlerForMessageThatProducesOutcome($this->handlerSpy),
            );

        $this->bus = MessageBus::build($settings);
    }

    public function messagesWithExpectedHandler(): array
    {
        return [
            [new MessageA(), HandlerForMessageA::class, null],
            [new MessageB(), HandlerForMessageB::class, null],
            [new MessageC(), HandlerForMessageC::class, null],
            [new MessageThatProducesOutcome(), HandlerForMessageThatProducesOutcome::class, new Outcome()],
        ];
    }

    /**
     * @test
     * @dataProvider messagesWithExpectedHandler
     */
    public function callCorrectHandler(
        object $message,
        string $expectedHandler,
        ?object $expectedOutcome,
    ): void {
        $outcome = $this->bus->dispatch($message);

        $this->assertHandlerAsCalled($expectedHandler);
        $this->assertEquals($expectedOutcome, $outcome);
    }

    private function assertHandlerAsCalled(string $expected): void
    {
        $this->assertInstanceOf($expected, $this->handlerSpy->calledHandler());
    }
}
