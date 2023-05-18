<?php

namespace Core\Logger;

use Core\Interfaces\LoggerFactory;
use Core\Interfaces\SimpleLogger;
use Core\Logger\Adapters\LoggerRouteStd;
use Core\Logger\Adapters\LoggerRouteNull;
use Core\Logger\Adapters\LoggerRouteFile;

class LoggerFactoryGeneric implements LoggerFactory
{

    /**
     * log to file
     * @param string $filename
     * @return SimpleLogger
     */
    public function logFile(string $filename): SimpleLogger
    {
        $logger = new LoggerGeneric();
        $logger->addBroadcast(new LoggerRouteFile(['filePath' => $filename]));
        return $logger;
    }

    /**
     * log to STD
     * @param string $filename
     * @return SimpleLogger
     */
    public function logStd(): SimpleLogger
    {
        $logger = new LoggerGeneric();
        $logger->addBroadcast(new LoggerRouteStd());
        return $logger;
    }

    /**
     * Log to null
     * @return SimpleLogger
     */
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
