<?php

declare(strict_types=1);

namespace Slam\Zend\Log;

use Laminas\Log\LoggerInterface;

interface LoggerAwareInterface
{
    public function setLogger(LoggerInterface $logger): void;

    public function getLogger(): LoggerInterface;
}
