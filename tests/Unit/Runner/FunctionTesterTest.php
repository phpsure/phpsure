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
use PHPSure\Assert\TypeAsserter;
use PHPSure\Discovery\DiscoveryResultInterface;
use PHPSure\Exception\TypeMismatchException;
use PHPSure\Generator\TokenGenerator;
use PHPSure\Runner\FunctionTester;
use PHPSure\Runner\Result\FailResult;
use PHPSure\Runner\Result\PassResult;
use PHPSure\Runner\Result\SkipResult;
use PHPSure\Tests\AbstractTestCase;
use ReflectionFunction;
use ReflectionType;
use RuntimeException;

/**
 * Class FunctionTesterTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class FunctionTesterTest extends AbstractTestCase
{
    private MockInterface&DiscoveryResultInterface $discoveryResult;
    private FunctionTester $functionTester;
    private MockInterface&TokenGenerator $tokenGenerator;
    private MockInterface&TypeAsserter $typeAsserter;

    public function setUp(): void
    {
        $this->tokenGenerator = mock(TokenGenerator::class);
        $this->typeAsserter = mock(TypeAsserter::class);
        $this->discoveryResult = mock(DiscoveryResultInterface::class);

        $this->functionTester = new FunctionTester(
            $this->tokenGenerator,
            $this->typeAsserter
        );
    }

    public function testTestFunctionsAddsPassResultWhenFunctionReturnsCorrectType(): void
    {
        $passes = [];
        $failures = [];
        $skips = [];
        $warnings = [];

        $this->discoveryResult->allows('getFunctionNames')
            ->andReturn(['PHPSure\Tests\Unit\Runner\myTestFunction']);

        $this->tokenGenerator->allows('generateForParameters')
            ->andReturn([]);

        $this->typeAsserter->allows('assertMatches');

        $this->functionTester->testFunctions(
            $this->discoveryResult,
            $passes,
            $failures,
            $skips,
            $warnings
        );

        $this->assertCount(1, $passes);
        $this->assertInstanceOf(PassResult::class, $passes[0]);
        $this->assertSame('PHPSure\Tests\Unit\Runner\myTestFunction()', $passes[0]->identifier);
        $this->assertCount(0, $failures);
        $this->assertCount(0, $skips);
        $this->assertCount(0, $warnings);
    }

    public function testTestFunctionsAddsFailResultWhenReturnTypeMismatchExceptionIsThrown(): void
    {
        $passes = [];
        $failures = [];
        $skips = [];
        $warnings = [];

        $this->discoveryResult->allows('getFunctionNames')
            ->andReturn(['PHPSure\Tests\Unit\Runner\myTestFunction']);

        $this->tokenGenerator->allows('generateForParameters')
            ->andReturn([]);

        $mockType = mock(ReflectionType::class);
        $mockType->allows('allowsNull')->andReturn(false);
        $mockType->allows('__toString')->andReturn('string');

        $this->typeAsserter->allows('assertMatches')
            ->andThrow(new TypeMismatchException('test', $mockType));

        $this->functionTester->testFunctions(
            $this->discoveryResult,
            $passes,
            $failures,
            $skips,
            $warnings
        );

        $this->assertCount(0, $passes);
        $this->assertCount(1, $failures);
        $this->assertInstanceOf(FailResult::class, $failures[0]);
        $this->assertSame('PHPSure\Tests\Unit\Runner\myTestFunction()', $failures[0]->identifier);
        $this->assertStringContainsString('Return type mismatch', $failures[0]->message);
        $this->assertCount(0, $skips);
        $this->assertCount(0, $warnings);
    }

    public function testTestFunctionsAddsSkipResultWhenOtherExceptionIsThrown(): void
    {
        $passes = [];
        $failures = [];
        $skips = [];
        $warnings = [];

        $this->discoveryResult->allows('getFunctionNames')
            ->andReturn(['PHPSure\Tests\Unit\Runner\myTestFunction']);

        $this->tokenGenerator->allows('generateForParameters')
            ->andThrow(new RuntimeException('Something went wrong'));

        $this->functionTester->testFunctions(
            $this->discoveryResult,
            $passes,
            $failures,
            $skips,
            $warnings
        );

        $this->assertCount(0, $passes);
        $this->assertCount(0, $failures);
        $this->assertCount(1, $skips);
        $this->assertInstanceOf(SkipResult::class, $skips[0]);
        $this->assertSame('PHPSure\Tests\Unit\Runner\myTestFunction()', $skips[0]->identifier);
        $this->assertSame('Something went wrong', $skips[0]->message);
        $this->assertCount(0, $warnings);
    }

    public function testTestFunctionsHandlesMultipleFunctions(): void
    {
        $passes = [];
        $failures = [];
        $skips = [];
        $warnings = [];

        $this->discoveryResult->allows('getFunctionNames')
            ->andReturn(['PHPSure\Tests\Unit\Runner\passingFunction', 'PHPSure\Tests\Unit\Runner\failingFunction', 'PHPSure\Tests\Unit\Runner\skippedFunction']);

        $this->tokenGenerator->allows('generateForParameters')
            ->andReturnUsing(function ($function) {
                if ($function->getName() === 'PHPSure\Tests\Unit\Runner\skippedFunction') {
                    throw new RuntimeException('Cannot generate args');
                }
                return [];
            });

        $mockType = mock(ReflectionType::class);
        $mockType->allows('allowsNull')->andReturn(false);
        $mockType->allows('__toString')->andReturn('string');

        $this->typeAsserter->allows('assertMatches')
            ->andReturnUsing(function ($result, $type) use ($mockType) {
                if ($result === 'fail') {
                    throw new TypeMismatchException('test', $mockType);
                }
            });

        $this->functionTester->testFunctions(
            $this->discoveryResult,
            $passes,
            $failures,
            $skips,
            $warnings
        );

        $this->assertCount(1, $passes);
        $this->assertSame('PHPSure\Tests\Unit\Runner\passingFunction()', $passes[0]->identifier);
        $this->assertCount(1, $failures);
        $this->assertSame('PHPSure\Tests\Unit\Runner\failingFunction()', $failures[0]->identifier);
        $this->assertCount(1, $skips);
        $this->assertSame('PHPSure\Tests\Unit\Runner\skippedFunction()', $skips[0]->identifier);
        $this->assertCount(0, $warnings);
    }

    public function testTestFunctionsPassesGeneratedArgsToFunction(): void
    {
        $passes = [];
        $failures = [];
        $skips = [];
        $warnings = [];

        $this->discoveryResult->allows('getFunctionNames')
            ->andReturn(['PHPSure\Tests\Unit\Runner\myTestFunctionWithArgs']);

        $this->tokenGenerator->expects('generateForParameters')
            ->once()
            ->with(\Mockery::type(ReflectionFunction::class))
            ->andReturn(['arg1', 'arg2']);

        $this->typeAsserter->allows('assertMatches');

        $this->functionTester->testFunctions(
            $this->discoveryResult,
            $passes,
            $failures,
            $skips,
            $warnings
        );

        $this->assertCount(1, $passes);
    }

    public function testTestFunctionsPassesReturnValueToTypeAsserter(): void
    {
        $passes = [];
        $failures = [];
        $skips = [];
        $warnings = [];

        $this->discoveryResult->allows('getFunctionNames')
            ->andReturn(['PHPSure\Tests\Unit\Runner\myTestFunction']);

        $this->tokenGenerator->allows('generateForParameters')
            ->andReturn([]);

        $this->typeAsserter->expects('assertMatches')
            ->once()
            ->with(
                'test result',
                \Mockery::type('ReflectionType')
            );

        $this->functionTester->testFunctions(
            $this->discoveryResult,
            $passes,
            $failures,
            $skips,
            $warnings
        );
    }
}

function myTestFunction(): string
{
    return 'test result';
}

function myTestFunctionWithArgs(string $arg1, string $arg2): string
{
    return $arg1 . $arg2;
}

function passingFunction(): string
{
    return 'pass';
}

function failingFunction(): string
{
    return 'fail';
}

function skippedFunction(): string
{
    return 'skip';
}
