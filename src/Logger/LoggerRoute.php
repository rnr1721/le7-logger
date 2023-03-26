<?php

namespace Core\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use \DateTime;

abstract class LoggerRoute extends AbstractLogger implements LoggerInterface
{

    protected bool $isEnable = true;

    /**
     * Date format
     */
    protected string $dateFormat = 'Y-m-d H:i';

    public function __construct(array $attributes = array())
    {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            }
        }
    }

    /**
     * Current date
     * @return string
     */
    protected function getDate(): string
    {
        return (new DateTime())->format($this->dateFormat);
    }

    /**
     * Convert $context to string
     * @param array $context
     * @return string
     */
    protected function toString(array $context = []): string
    {
        return !empty($context) ? json_encode($context) : '';
    }

    /**
     * If route enabled
     * @return bool
     */
    public function isEnable(): bool
    {
        return $this->isEnable;
    }

    /**
     * Turn on or off this route
     * @param bool $enabled State
     * @return self
     */
    public function setIsEnable(bool $enabled): self
    {
        $this->isEnable = $enabled;
        return $this;
    }

    /**
     * Set default date format
     * Default is Y-m-d H:i
     * @param string $dateFormat Date format
     * @return self
     */
    public function setDateFormat(string $dateFormat = 'Y-m-d H:i'): self
    {
        $this->dateFormat = $dateFormat;
        return $this;
    }

}
