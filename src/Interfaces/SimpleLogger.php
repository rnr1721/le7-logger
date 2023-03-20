<?php

namespace Core\Logger\Interfaces;

use Core\Logger\LoggerRoute;
use Psr\Log\LoggerInterface;

interface SimpleLogger extends LoggerInterface
{

    public function addBroadcast(LoggerRoute $route): self;
}
