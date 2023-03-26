<?php

namespace Core\Logger\Adapters;

use Core\Logger\LoggerRoute;
use Stringable;
use function count;

class LoggerRouteNull extends LoggerRoute
{

    protected bool $isEnable = true;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function log($level, Stringable|string $message, array $context = []): void
    {
        $result = [
            $level,
            $message,
            $context
        ];
        count($result);
        return;
    }

}
