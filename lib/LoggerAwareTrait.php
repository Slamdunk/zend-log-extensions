<?php

declare(strict_types=1);

namespace Slam\Zend\Log;

use Laminas\Log\Logger;
use Laminas\Log\LoggerInterface;
use Laminas\Log\Writer\Noop;

trait LoggerAwareTrait
{
    /**
     * @var null|LoggerInterface
     */
    private $logger;

    public function setLogger(LoggerInterface $logger): void
    {
        if (null !== $this->logger) {
            throw new Exception\RuntimeException('Logger already set, cannot be overwritten');
        }

        $this->logger = $logger;
    }

    public function getLogger(): LoggerInterface
    {
        if (null === $this->logger) {
            $this->logger = new Logger();
            $this->logger->addWriter(new Noop());
        }

        return $this->logger;
    }
}
