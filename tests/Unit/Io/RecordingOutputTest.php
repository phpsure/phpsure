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

use PHPSure\Io\RecordingOutput;
use PHPSure\Tests\AbstractTestCase;

/**
 * Class RecordingOutputTest.
 *
 * Unit tests for the RecordingOutput class.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class RecordingOutputTest extends AbstractTestCase
{
    public function testGetOutputReturnsEmptyStringInitially(): void
    {
        $output = new RecordingOutput();

        static::assertSame('', $output->getOutput());
    }

    public function testWriteRecordsMessage(): void
    {
        $output = new RecordingOutput();

        $output->write('Hello, World!');

        static::assertSame('Hello, World!', $output->getOutput());
    }

    public function testWriteRecordsMultipleMessages(): void
    {
        $output = new RecordingOutput();

        $output->write('First message');
        $output->write(' Second message');

        static::assertSame('First message Second message', $output->getOutput());
    }

    public function testWriteRecordsEmptyString(): void
    {
        $output = new RecordingOutput();

        $output->write('');

        static::assertSame('', $output->getOutput());
    }

    public function testWriteAppendsToExistingOutput(): void
    {
        $output = new RecordingOutput();

        $output->write('Line 1' . PHP_EOL);
        $output->write('Line 2' . PHP_EOL);
        $output->write('Line 3');

        static::assertSame('Line 1' . PHP_EOL . 'Line 2' . PHP_EOL . 'Line 3', $output->getOutput());
    }
}
