<?php

namespace Core\Logger;

use Core\Logger\LoggerRoute;
use Core\Interfaces\SimpleLoggerInterface;
use Psr\Log\AbstractLogger;
use Stringable;

class LoggerGeneric extends AbstractLogger implements SimpleLoggerInterface
{

    /**
     * Array of logger routes for broadcast
     * @var array
     */
    private array $broadcast = array();

    /**
     * Log the message
     * @param mixed $level Log level
     * @param Stringable|string $message Message
     * @param array $context Context
     * @return void
     */
    public function log($level, Stringable|string $message, array $context = []): void
    {
        foreach ($this->broadcast as $route) {
            if (!$route instanceof LoggerRoute) {
                continue;
            }
            if (!$route->isEnable()) {
                continue;
            }
            $route->log($level, $message, $context);
        }
    }

    /**
     * Add broadcast item to logging
     * @param LoggerRoute $route Route
     * @return self
     */
    public function addBroadcast(LoggerRoute $route): self
    {
        $this->broadcast[] = $route;
        return $this;
    }

}
