[![Build Status]](https://github.com/bauhausphp/message-bus/actions)
[![Coverage]](https://coveralls.io/github/bauhausphp/message-bus?branch=main)

[![Stable Version]](https://packagist.org/packages/bauhaus/message-bus)
[![Downloads]](https://packagist.org/packages/bauhaus/message-bus)
[![PHP Version]](composer.json)
[![License]](LICENSE)

[Build Status]: https://img.shields.io/github/workflow/status/bauhausphp/message-bus/CI?style=flat-square
[Coverage]: https://img.shields.io/coveralls/github/bauhausphp/message-bus?style=flat-square
[Stable Version]: https://img.shields.io/packagist/v/bauhaus/message-bus?style=flat-square
[Downloads]: https://img.shields.io/packagist/dt/bauhaus/message-bus?style=flat-square
[PHP Version]: https://img.shields.io/packagist/php-v/bauhaus/message-bus?style=flat-square
[License]: https://img.shields.io/github/license/bauhausphp/message-bus?style=flat-square

# Message Bus

## Installing

```
$ composer require bauhaus/message-bus
```

# Getting Started

```php
<?php

use Bauhaus\MessageBus;
use Bauhaus\MessageBusSettings;

class YourCommand {}
class YourCommandHandler
{
    public function __invoke(CommandA $command): void {}
}

class YourQuery {}
class YourQueryResult {}
class YourQueryHandler
{
    public function __invoke(YourQuery $query): YourQueryResult
    {
        return new YourQueryResult();
    }
}

$messageBus = MessageBus::build(
    MessageBusSettings::new()
        ->withPsrContainer(/* Pass here your favorite PSR container */)
        ->withHandlers(
            YourCommandAHandler::class,
            YourQueryHandler::class,
        );
);

$result = $messageBus->dispatch(new YourCommand());
is_null($result); // true

$result = $messageBus->dispatch(new YourCommand());
$result instanceof YourQueryResult; // true
```

# Contributing

Open an issue: https://github.com/bauhausphp/message-bus/issues
Code: https://github.com/bauhausphp/contributor-tool
