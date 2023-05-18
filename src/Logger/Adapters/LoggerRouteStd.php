<?php

namespace Core\Logger\Adapters;

use Core\Logger\LoggerRoute;
use \Stringable;

/**
 * Logger for STDerr or STDout. For example it usable in docker
 */
class LoggerRouteStd extends LoggerRoute
{

    /**
     * For tests - echo result
     * @var bool
     */
    public bool $echo = false;

    /**
     * if this logger route enabled
     * @var bool
     */
    protected bool $isEnable = true;

    /**
     * Log entry template
     * @var string Default: {date} {level} {message} {context}
     */
    public string $template = "{date} {level} {message} {context}";

    /**
     * 
     * @param mixed $level
     * @param Stringable|string $message
     * @param array $context
     * @return void
     */
    public function log($level, Stringable|string $message, array $context = []): void
    {

        $logEntry = trim(strtr($this->template, [
            '{date}' => $this->getDate(),
            '{level}' => $level,
            '{message}' => $message,
            '{context}' => $this->toString($context),
        ]));

        if ($this->isErrorLevel($level)) {
            fwrite(STDERR, $logEntry . PHP_EOL);
        } else {
            fwrite(STDOUT, $logEntry . PHP_EOL);
        }

        if ($this->echo) {
            echo $logEntry;
        }
    }

    /**
     * Set log entry template
     * @param string $template
     * @return self
     */
    public function setTemplate(string $template): self
    {
        $this->template = $template;
        return $this;
    }

    /**
     * Whitch of these levels is errors. Other will go to stdout
     * @param string $level
     * @return bool
     */
    protected function isErrorLevel(string $level): bool
    {
        return in_array(
                $level,
                [
                    'error',
                    'critical',
                    'alert',
                    'emergency'
        ]);
    }

}
