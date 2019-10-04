<?php

declare(strict_types=1);

namespace Slam\Zend\Log\Tests;

use PHPUnit\Framework\TestCase;
use Slam\Zend\Log\Exception;
use Slam\Zend\Log\LoggerAwareTrait;
use Zend\Log\LoggerInterface;

/**
 * @covers \Slam\Zend\Log\LoggerAwareTrait
 */
final class LoggerAwareTraitTest extends TestCase
{
    private $logger;
    private $loggerAware;

    protected function setUp()
    {
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->loggerAware = $this->getObjectForTrait(LoggerAwareTrait::class);
    }

    public function testSetAndRetrieve()
    {
        $this->loggerAware->setLogger($this->logger);

        static::assertSame($this->logger, $this->loggerAware->getLogger());
    }

    public function testLoggerCannotBeOverwritten()
    {
        $logger1 = clone $this->logger;
        $logger2 = clone $this->logger;

        $this->loggerAware->setLogger($logger1);

        $this->expectException(Exception\RuntimeException::class);
        $this->loggerAware->setLogger($logger2);
    }

    public function testHasADefaultNullLogger()
    {
        static::assertInstanceOf(LoggerInterface::class, $this->loggerAware->getLogger());
    }
}
