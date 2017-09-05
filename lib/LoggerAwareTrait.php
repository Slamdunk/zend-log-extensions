<?php

declare(strict_types=1);

namespace Slam\Zend\Log;

use Zend\Log\Logger;
use Zend\Log\LoggerInterface;
use Zend\Log\Writer\Noop;

trait LoggerAwareTrait
{
    private $logger;

    public function setLogger(LoggerInterface $logger)
    {
        if ($this->logger !== null) {
            throw new Exception\RuntimeException('Logger already set, cannot be overwritten');
        }

        $this->logger = $logger;
    }

    public function getLogger(): LoggerInterface
    {
        if ($this->logger === null) {
            $this->logger = new Logger();
            $this->logger->addWriter(new Noop());
        }

        return $this->logger;
    }
}
