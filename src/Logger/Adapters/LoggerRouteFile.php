<?php

namespace Core\Logger\Adapters;

use Core\Logger\LoggerRoute;
use \Exception;
use \Stringable;

/**
 * File logger
 */
class LoggerRouteFile extends LoggerRoute
{

    /**
     * If this logger route enable
     * @var bool
     */
    protected bool $isEnable = true;

    /**
     * Path to file log
     * @var string|null
     */
    public ?string $filePath = null;

    /**
     * Log record template
     * @var string
     */
    public string $template = "{date} {level} {message} {context}";

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (is_string($this->filePath) && !file_exists($this->filePath)) {
            touch($this->filePath);
        }
    }

    /**
     * Log to file
     * @param mixed $level
     * @param Stringable|string $message
     * @param array $context
     * @return void
     * @throws Exception
     */
    public function log($level, Stringable|string $message, array $context = []): void
    {
        if (is_null($this->filePath)) {
            throw new Exception("LoggerRouteFile::log() Please specify filename");
        }
        file_put_contents($this->filePath, trim(strtr($this->template, [
                    '{date}' => $this->getDate(),
                    '{level}' => $level,
                    '{message}' => $message,
                    '{context}' => $this->toString($context),
                ])) . PHP_EOL, FILE_APPEND);
    }

    /**
     * Set file path for log file
     * @param string $filePath File will be created if not exists
     * @return self
     */
    public function setFilePath(string $filePath): self
    {
        $this->filePath = $filePath;
        return $this;
    }

    /**
     * Set template.
     * @param string $template Default: {date} {level} {message} {context}
     * @return self
     */
    public function setTemplate(string $template): self
    {
        $this->template = $template;
        return $this;
    }

}
