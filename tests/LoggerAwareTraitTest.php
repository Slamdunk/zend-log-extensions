<?php

declare(strict_types=1);

namespace Slam\Zend\Log\Tests;

use Laminas\Log\LoggerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Slam\Zend\Log\Exception;
use Slam\Zend\Log\LoggerAwareInterface;
use Slam\Zend\Log\LoggerAwareTrait;

/**
 * @covers \Slam\Zend\Log\LoggerAwareTrait
 */
final class LoggerAwareTraitTest extends TestCase
{
    /**
     * @var MockObject&LoggerInterface
     */
    private $logger;

    /**
     * @var LoggerAwareInterface
     */
    private $loggerAware;

    protected function setUp(): void
    {
        $this->logger = $this->createMock(LoggerInterface::class);

        /** @var LoggerAwareInterface $loggerAware */
        $loggerAware       = $this->getObjectForTrait(LoggerAwareTrait::class);
        $this->loggerAware = $loggerAware;
    }

    public function testSetAndRetrieve(): void
    {
        $this->loggerAware->setLogger($this->logger);

        self::assertSame($this->logger, $this->loggerAware->getLogger());
    }

    public function testLoggerCannotBeOverwritten(): void
    {
        $logger1 = clone $this->logger;
        $logger2 = clone $this->logger;

        $this->loggerAware->setLogger($logger1);

        $this->expectException(Exception\RuntimeException::class);
        $this->loggerAware->setLogger($logger2);
    }

    public function testHasADefaultNullLogger(): void
    {
        self::assertInstanceOf(LoggerInterface::class, $this->loggerAware->getLogger());
    }
}
