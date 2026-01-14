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

namespace PHPSure\Tests\Unit\Bin;

use Mockery\MockInterface;
use PHPSure\Bin\PhpSureBinary;
use PHPSure\Bin\ScanCommandInterface;
use PHPSure\Io\RecordingOutput;
use PHPSure\Runner\Result\TestResult;
use PHPSure\Tests\AbstractTestCase;

/**
 * Class PhpSureBinaryTest.
 *
 * Unit tests for the PhpSureBinary class.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class PhpSureBinaryTest extends AbstractTestCase
{
    private RecordingOutput $stderr;
    private ScanCommandInterface&MockInterface $scanCommand;
    private PhpSureBinary $phpSure;

    protected function setUp(): void
    {
        parent::setUp();

        $this->scanCommand = mock(ScanCommandInterface::class);
        $this->stderr = new RecordingOutput();

        $this->phpSure = new PhpSureBinary($this->scanCommand, $this->stderr);
    }

    public function testRunReturnsErrorCodeWhenNoCommandProvided(): void
    {
        $argv = ['phpsure'];

        $exitCode = $this->phpSure->run($argv);

        static::assertSame(1, $exitCode);
        static::assertStringContainsString('Usage: phpsure scan', $this->stderr->getOutput());
    }

    public function testRunReturnsErrorCodeWhenUnknownCommandProvided(): void
    {
        $argv = ['phpsure', 'unknown'];

        $exitCode = $this->phpSure->run($argv);

        static::assertSame(1, $exitCode);
        static::assertStringContainsString('Error: Unknown command "unknown"', $this->stderr->getOutput());
        static::assertStringContainsString('Usage: phpsure scan', $this->stderr->getOutput());
    }

    public function testRunReturnsErrorCodeWhenNoDirectoryProvided(): void
    {
        $argv = ['phpsure', 'scan'];

        $exitCode = $this->phpSure->run($argv);

        static::assertSame(1, $exitCode);
        static::assertStringContainsString('Error: Path argument is required', $this->stderr->getOutput());
        static::assertStringContainsString('Usage: phpsure scan', $this->stderr->getOutput());
    }

    public function testRunReturnsErrorCodeWhenPathDoesNotExist(): void
    {
        $argv = ['phpsure', 'scan', '/nonexistent/path'];

        $this->scanCommand->expects('run')
            ->once()
            ->with('/nonexistent/path', [])
            ->andReturn(null);

        $exitCode = $this->phpSure->run($argv);

        static::assertSame(1, $exitCode);
    }

    public function testRunExecutesScanAndReturnsSuccessWhenNoFailures(): void
    {
        $testResult = mock(TestResult::class);
        $testResult->allows('hasFailures')
            ->andReturn(false);

        $this->scanCommand->expects('run')
            ->once()
            ->with(__DIR__, [])
            ->andReturn($testResult);

        $argv = ['phpsure', 'scan', __DIR__];

        $exitCode = $this->phpSure->run($argv);

        static::assertSame(0, $exitCode);
    }

    public function testRunExecutesScanAndReturnsFailureWhenFailuresExist(): void
    {
        $testResult = mock(TestResult::class);
        $testResult->allows('hasFailures')
            ->andReturn(true);

        $this->scanCommand->expects('run')
            ->once()
            ->with(__DIR__, [])
            ->andReturn($testResult);

        $argv = ['phpsure', 'scan', __DIR__];

        $exitCode = $this->phpSure->run($argv);

        static::assertSame(3, $exitCode);
    }

    public function testRunWritesUsageToStderr(): void
    {
        $argv = ['phpsure'];

        $this->phpSure->run($argv);

        $stderrOutput = $this->stderr->getOutput();
        static::assertStringContainsString('Usage: phpsure scan <directory-or-file>', $stderrOutput);
        static::assertStringContainsString('scan    Scan the given directory or file and run contract checks', $stderrOutput);
    }
}
