<?php

namespace Core\Interfaces;

interface LoggerFactoryInterface
{

    /**
     * Simple log to some file
     * The file will created if not exists
     * @param string $filename Path to file
     * @return SimpleLoggerInterface
     */
    public function logFile(string $filename): SimpleLoggerInterface;

    /**
     * Simple log to std
     * Info will go to stdout, errors go to stderr
     * @return SimpleLoggerInterface
     */
    public function logStd(): SimpleLoggerInterface;
    
    /**
     * Log adapter stub. Do not make anything;
     * @return SimpleLoggerInterface
     */
    public function logNull(): SimpleLoggerInterface;

    /**
     * Get logger without imported adapter
     * You can make plug own that extends of LoggerRoute
     * @return SimpleLoggerInterface
     */
    public function getLogger(): SimpleLoggerInterface;
}
