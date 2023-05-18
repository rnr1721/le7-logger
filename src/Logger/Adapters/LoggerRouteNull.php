<?php

namespace Core\Logger\Adapters;

use Core\Logger\LoggerRoute;
use Stringable;
use function count;

/**
 * Null logger
 */
class LoggerRouteNull extends LoggerRoute
{

    /**
     * If this log route enabled
     * @var bool
     */
    protected bool $isEnable = true;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Log to null
     * @param mixed $level
     * @param Stringable|string $message
     * @param array $context
     * @return void
     */
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
