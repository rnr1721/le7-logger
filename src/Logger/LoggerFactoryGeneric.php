<?php

namespace Core\Logger;

use Core\Interfaces\LoggerFactory;
use Core\Interfaces\SimpleLogger;
use Core\Logger\Adapters\LoggerRouteNull;
use Core\Logger\Adapters\LoggerRouteFile;

class LoggerFactoryGeneric implements LoggerFactory
{

    public function logFile(string $filename): SimpleLogger
    {
        $logger = new LoggerGeneric();
        $logger->addBroadcast(new LoggerRouteFile(['filePath' => $filename]));
        return $logger;
    }

    public function logNull(): SimpleLogger
    {
        $logger = new LoggerGeneric();
        $logger->addBroadcast(new LoggerRouteNull());
        return $logger;
    }

    public function getLogger(): SimpleLogger
    {
        return new LoggerGeneric();
    }

}
