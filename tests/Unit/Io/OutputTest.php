<?php

/*
 * PHPSure
 * Copyright (c) Dan Phillimore (asmblah)
 * https://github.com/phpsure/phpsure/
 *
 * Released under the MIT license.
 * https://github.com/phpsure/phpsure/raw/main/MIT-LICENSE.txt
 */

declare(strict_types=1);

namespace PHPSure\Tests\Unit\Io;

use PHPSure\Io\Output;
use PHPSure\Tests\AbstractTestCase;

/**
 * Class OutputTest.
 *
 * Unit tests for the Output class.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class OutputTest extends AbstractTestCase
{
    public function testWriteWritesMessageToStream(): void
    {
        $stream = fopen('php://memory', 'w+');
        $output = new Output($stream);

        $output->write('Hello, World!');

        rewind($stream);
        $content = stream_get_contents($stream);
        fclose($stream);

        static::assertSame('Hello, World!', $content);
    }

    public function testWriteWritesMultipleMessagesToStream(): void
    {
        $stream = fopen('php://memory', 'w+');
        $output = new Output($stream);

        $output->write('First message');
        $output->write(' Second message');

        rewind($stream);
        $content = stream_get_contents($stream);
        fclose($stream);

        static::assertSame('First message Second message', $content);
    }

    public function testWriteWritesEmptyStringToStream(): void
    {
        $stream = fopen('php://memory', 'w+');
        $output = new Output($stream);

        $output->write('');

        rewind($stream);
        $content = stream_get_contents($stream);
        fclose($stream);

        static::assertSame('', $content);
    }
}
