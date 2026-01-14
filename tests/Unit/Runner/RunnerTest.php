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

namespace PHPSure\Tests\Unit\Runner;

use Mockery\MockInterface;
use PHPSure\Discovery\DiscoveryResultInterface;
use PHPSure\Discovery\Scanner;
use PHPSure\Runner\ClassTesterInterface;
use PHPSure\Runner\FunctionTesterInterface;
use PHPSure\Runner\Result\FailResult;
use PHPSure\Runner\Result\PassResult;
use PHPSure\Runner\Result\SkipResult;
use PHPSure\Runner\Result\TestResult;
use PHPSure\Runner\Result\WarningResult;
use PHPSure\Runner\Runner;
use PHPSure\Tests\AbstractTestCase;

/**
 * Class RunnerTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class RunnerTest extends AbstractTestCase
{
    private MockInterface&ClassTesterInterface $classTester;
    private MockInterface&FunctionTesterInterface $functionTester;
    private Runner $runner;
    private MockInterface&Scanner $scanner;

    public function setUp(): void
    {
        $this->classTester = mock(ClassTesterInterface::class);
        $this->functionTester = mock(FunctionTesterInterface::class);
        $this->scanner = mock(Scanner::class);

        $this->runner = new Runner($this->scanner, $this->functionTester, $this->classTester);
    }

    public function testRunScansPathAndTestsFunctionsAndClasses(): void
    {
        $discoveryResult = mock(DiscoveryResultInterface::class);

        $this->scanner->expects('scan')
            ->once()
            ->with('/path/to/test')
            ->andReturn($discoveryResult);
        $this->functionTester->expects('testFunctions')
            ->once()
            ->with($discoveryResult, [], [], [], []);
        $this->classTester->expects('testClasses')
            ->once()
            ->with($discoveryResult, [], [], [], []);

        $result = $this->runner->run('/path/to/test');

        static::assertInstanceOf(TestResult::class, $result);
    }

    public function testRunReturnsTestResultWithPassesFromFunctionTester(): void
    {
        $discoveryResult = mock(DiscoveryResultInterface::class);
        $passResult = new PassResult('myFunction()');
        $this->scanner->allows('scan')
            ->andReturn($discoveryResult);
        $this->functionTester->allows('testFunctions')
            ->andReturnUsing(function ($discovery, &$passes, &$failures, &$skips, &$warnings) use ($passResult) {
                $passes[] = $passResult;
            });
        $this->classTester->allows('testClasses');

        $result = $this->runner->run('/path/to/test');

        static::assertCount(1, $result->getPasses());
        static::assertSame($passResult, $result->getPasses()[0]);
        static::assertCount(0, $result->getFailures());
        static::assertCount(0, $result->getSkips());
        static::assertCount(0, $result->getWarnings());
    }

    public function testRunReturnsTestResultWithFailuresFromFunctionTester(): void
    {
        $discoveryResult = mock(DiscoveryResultInterface::class);
        $failResult = new FailResult('myFunction()', 'Type mismatch');
        $this->scanner->allows('scan')
            ->andReturn($discoveryResult);
        $this->functionTester->allows('testFunctions')
            ->andReturnUsing(function ($discovery, &$passes, &$failures, &$skips, &$warnings) use ($failResult) {
                $failures[] = $failResult;
            });
        $this->classTester->allows('testClasses');

        $result = $this->runner->run('/path/to/test');

        static::assertCount(0, $result->getPasses());
        static::assertCount(1, $result->getFailures());
        static::assertSame($failResult, $result->getFailures()[0]);
        static::assertCount(0, $result->getSkips());
        static::assertCount(0, $result->getWarnings());
    }

    public function testRunReturnsTestResultWithSkipsFromFunctionTester(): void
    {
        $discoveryResult = mock(DiscoveryResultInterface::class);
        $skipResult = new SkipResult('myFunction()', 'Exception thrown');
        $this->scanner->allows('scan')
            ->andReturn($discoveryResult);
        $this->functionTester->allows('testFunctions')
            ->andReturnUsing(function ($discovery, &$passes, &$failures, &$skips, &$warnings) use ($skipResult) {
                $skips[] = $skipResult;
            });
        $this->classTester->allows('testClasses');

        $result = $this->runner->run('/path/to/test');

        static::assertCount(0, $result->getPasses());
        static::assertCount(0, $result->getFailures());
        static::assertCount(1, $result->getSkips());
        static::assertSame($skipResult, $result->getSkips()[0]);
        static::assertCount(0, $result->getWarnings());
    }

    public function testRunReturnsTestResultWithWarningsFromClassTester(): void
    {
        $discoveryResult = mock(DiscoveryResultInterface::class);
        $warningResult = new WarningResult('MyClass->myMethod()', 'Private constructor');
        $this->scanner->allows('scan')
            ->andReturn($discoveryResult);
        $this->functionTester->allows('testFunctions');
        $this->classTester->allows('testClasses')
            ->andReturnUsing(function ($discovery, &$passes, &$failures, &$skips, &$warnings) use ($warningResult) {
                $warnings[] = $warningResult;
            });

        $result = $this->runner->run('/path/to/test');

        static::assertCount(0, $result->getPasses());
        static::assertCount(0, $result->getFailures());
        static::assertCount(0, $result->getSkips());
        static::assertCount(1, $result->getWarnings());
        static::assertSame($warningResult, $result->getWarnings()[0]);
    }

    public function testRunReturnsTestResultWithMixedResults(): void
    {
        $discoveryResult = mock(DiscoveryResultInterface::class);
        $passResult = new PassResult('myFunction()');
        $failResult = new FailResult('myOtherFunction()', 'Type mismatch');
        $skipResult = new SkipResult('MyClass::myMethod()', 'Exception');
        $warningResult = new WarningResult('MyClass->myMethod()', 'Warning');
        $this->scanner->allows('scan')
            ->andReturn($discoveryResult);
        $this->functionTester->allows('testFunctions')
            ->andReturnUsing(function ($discovery, &$passes, &$failures, &$skips, &$warnings) use ($passResult, $failResult) {
                $passes[] = $passResult;
                $failures[] = $failResult;
            });
        $this->classTester->allows('testClasses')
            ->andReturnUsing(function ($discovery, &$passes, &$failures, &$skips, &$warnings) use ($skipResult, $warningResult) {
                $skips[] = $skipResult;
                $warnings[] = $warningResult;
            });

        $result = $this->runner->run('/path/to/test');

        static::assertCount(1, $result->getPasses());
        static::assertSame($passResult, $result->getPasses()[0]);
        static::assertCount(1, $result->getFailures());
        static::assertSame($failResult, $result->getFailures()[0]);
        static::assertCount(1, $result->getSkips());
        static::assertSame($skipResult, $result->getSkips()[0]);
        static::assertCount(1, $result->getWarnings());
        static::assertSame($warningResult, $result->getWarnings()[0]);
    }
}
