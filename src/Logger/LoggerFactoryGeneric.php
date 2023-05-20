<?php

namespace Core\Logger;

use Core\Interfaces\LoggerFactoryInterface;
use Core\Interfaces\SimpleLoggerInterface;
use Core\Logger\Adapters\LoggerRouteStd;
use Core\Logger\Adapters\LoggerRouteNull;
use Core\Logger\Adapters\LoggerRouteFile;

class LoggerFactoryGeneric implements LoggerFactoryInterface
{

    /**
     * log to file
     * @param string $filename
     * @return SimpleLoggerInterface
     */
    public function logFile(string $filename): SimpleLoggerInterface
    {
        $logger = new LoggerGeneric();
        $logger->addBroadcast(new LoggerRouteFile(['filePath' => $filename]));
        return $logger;
    }

    /**
     * log to STD
     * @param string $filename
     * @return SimpleLoggerInterface
     */
    public function logStd(): SimpleLoggerInterface
    {
        $logger = new LoggerGeneric();
        $logger->addBroadcast(new LoggerRouteStd());
        return $logger;
    }

    /**
     * Log to null
     * @return SimpleLoggerInterface
     */
    public function logNull(): SimpleLoggerInterface
    {
        $logger = new LoggerGeneric();
        $logger->addBroadcast(new LoggerRouteNull());
        return $logger;
    }

    public function getLogger(): SimpleLoggerInterface
    {
        return new LoggerGeneric();
    }

}
