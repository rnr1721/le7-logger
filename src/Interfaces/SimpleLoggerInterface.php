<?php

namespace Core\Interfaces;

use Core\Logger\LoggerRoute;
use Psr\Log\LoggerInterface;

interface SimpleLoggerInterface extends LoggerInterface
{

    /**
     * Add destination to broadcast log
     * @param LoggerRoute $route Destination
     * @return self
     */
    public function addBroadcast(LoggerRoute $route): self;
}
