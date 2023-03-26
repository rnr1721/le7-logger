<?php

namespace Core\Logger\Adapters;

use Core\Logger\LoggerRoute;
use \Exception;
use \Stringable;

class LoggerRouteFile extends LoggerRoute
{

    protected bool $isEnable = true;
    public ?string $filePath = null;
    public string $template = "{date} {level} {message} {context}";

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (is_string($this->filePath) && !file_exists($this->filePath)) {
            touch($this->filePath);
        }
    }

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

    public function setFilePath(string $filePath): self
    {
        $this->filePath = $filePath;
        return $this;
    }

    public function setTemplate(string $template): self
    {
        $this->template = $template;
        return $this;
    }

}
