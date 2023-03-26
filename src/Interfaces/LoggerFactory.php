<?php

namespace Core\Interfaces;

interface LoggerFactory
{

    /**
     * Simple log to some file
     * The file will created if not exists
     * @param string $filename Path to file
     * @return SimpleLogger
     */
    public function logFile(string $filename): SimpleLogger;

    /**
     * Log adapter stub. Do not make anything;
     * @return SimpleLogger
     */
    public function logNull(): SimpleLogger;

    /**
     * Get logger without imported adapter
     * You can make plug own that extends of LoggerRoute
     * @return SimpleLogger
     */
    public function getLogger(): SimpleLogger;
}
