# Simple PSR-3 logger class for le7 framework or any PHP project

## Requirements

- PHP 8.1 or higher.
- Composer 2.0 or higher.

## What it can?

- Log to any destination (need to write similar adapter), by default present file and null
- Write more than one destination (for example in two files similarry or to file and to db)

## Installation

```shell
composer require rnr1721/le7-logger
```

## How use it?

```php

use Core\Logger\LoggerFactoryGeneric;

    $factory = new LoggerFactoryGeneric();

    $log = $this->factory->logFile('/home/www/example.com/myproject/log.txt');

    // Use it as any PSR logger
    $log->info('info message');
    $log->critical('alert message');

```

## How use different destinations?

For example, we need to write file to two different destinations


```php

use Core\Logger\LoggerFactoryGeneric;

    $factory = new LoggerFactoryGeneric();

    $path1 = '/home/www/example.com/myproject/log1.txt';
    $path2 = '/home/www/example.com/myproject/log2.txt';

    $log = $this->factory->getLogger();

    $log->addBroadcast(new LoggerRouteFile(['filePath' => $path1]))
            ->addBroadcast(new LoggerRouteFile(['filePath' => $path2]));

    // Use it as any PSR logger
    $log->info('info message');
    $log->critical('alert message');

```

## Different format in file adapter

```php
use Core\Logger\Adapters\LoggerRouteFile;

// ...

    $params = [
        'filePath' => '/path/to/your/log.log',
        'template' => '{date} {level} {message} {context}';
    ];

    $log->addBroadcast(new LoggerRouteFile($params));

```
or different way

```php
use Core\Logger\Adapters\LoggerRouteFile;

// ...

    $loggerRouteFile = new LoggerRouteFile();
    $loggerRouteFile->setFilePath('/your/file/path')
        ->setTemplate('{date} {level} {message} {context}');

    $log->addBroadcast($loggerRouteFile);

```
