<?php

declare(strict_types=1);

namespace Slam\Zend\Log\Tests\Formatter;

use Laminas\Log\Formatter\Simple as ZendSimple;
use PHPUnit\Framework\TestCase;
use Slam\Zend\Log\Formatter\MemorySimple;

/**
 * @covers \Slam\Zend\Log\Formatter\MemorySimple
 */
final class MemorySimpleTest extends TestCase
{
    public function testInit(): void
    {
        $formatter = new MemorySimple();

        self::assertInstanceOf(ZendSimple::class, $formatter);
        self::assertNotNull($formatter->format([]));
    }
}
