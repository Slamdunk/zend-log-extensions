<?php

declare(strict_types=1);

namespace Slam\Zend\Log\Tests\Writer;

use PHPUnit\Framework\TestCase;
use Slam\Zend\Log\Writer\RotateStream;
use Zend\Log\Formatter\Simple as SimpleFormatter;

/**
 * @covers \Slam\Zend\Log\Writer\RotateStream
 */
final class RotateStreamTest extends TestCase
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @var RotateStream
     */
    private $writer;

    protected function setUp()
    {
        $this->filename = \sprintf('%s/rotate_stream_assests/log.txt', __DIR__);
        $this->purgeAssets();

        $this->writer = new RotateStream([
            'stream'        => $this->filename,
            'mode'          => null,
            'log_separator' => '',
        ]);
        $this->writer->setFormatter(new SimpleFormatter('%message%'));
    }

    protected function tearDown()
    {
        $this->purgeAssets();
    }

    public function testOptions()
    {
        static::assertSame($this->filename, $this->writer->getStreamname());

        static::assertGreaterThan(1, $this->writer->getCheckProbability());
        static::assertGreaterThan(1, $this->writer->getMaxFileSize());

        $this->writer->setCheckProbability(1);
        $this->writer->setMaxFileSize(1);

        static::assertSame(1, $this->writer->getCheckProbability());
        static::assertSame(1, $this->writer->getMaxFileSize());
    }

    public function testLogRotation()
    {
        \file_put_contents($this->filename . '.1', 'ABC');

        $this->writer->setCheckProbability(2);
        $this->writer->setMaxFileSize(10);

        for ($i = 0; $i < 13; ++$i) {
            $this->writer->write([
                'message' => '1',
            ]);
        }

        static::assertSame('11', \file_get_contents($this->filename));

        $newFile = $this->filename . '.2';
        static::assertFileExists($newFile);

        $content = \file_get_contents($newFile);

        static::assertContains(\str_repeat('1', 11), $content);
        static::assertContains('LOG ROTATE', $content);
    }

    private function purgeAssets()
    {
        foreach (\glob(\sprintf('%s*', $this->filename)) as $file) {
            \unlink($file);
        }
    }
}
