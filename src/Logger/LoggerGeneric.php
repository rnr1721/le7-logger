<?php

namespace Core\Logger;

use Core\Logger\LoggerRoute;
use Core\Interfaces\SimpleLogger;
use Psr\Log\AbstractLogger;
use Stringable;

class LoggerGeneric extends AbstractLogger implements SimpleLogger
{

    private array $broadcast = array();

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

    public function addBroadcast(LoggerRoute $route): self
    {
        $this->broadcast[] = $route;
        return $this;
    }

}
