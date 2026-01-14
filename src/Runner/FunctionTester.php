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

namespace PHPSure\Runner;

use PHPSure\Assert\TypeAsserter;
use PHPSure\Discovery\DiscoveryResultInterface;
use PHPSure\Exception\ReturnTypeMismatchException;
use PHPSure\Exception\TypeMismatchException;
use PHPSure\Generator\TokenGenerator;
use PHPSure\Runner\Result\FailResult;
use PHPSure\Runner\Result\PassResult;
use PHPSure\Runner\Result\SkipResult;
use PHPSure\Runner\Result\WarningResult;
use ReflectionFunction;
use Throwable;

/**
 * Class FunctionTester.
 *
 * Tests functions.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class FunctionTester implements FunctionTesterInterface
{
    public function __construct(
        private readonly TokenGenerator $tokenGenerator,
        private readonly TypeAsserter $typeAsserter
    ) {
    }

    /**
     * Tests all discovered functions.
     *
     * @param DiscoveryResultInterface $discoveryResult The result of scanning for functions.
     * @param array<PassResult> &$passes Output parameter for pass results.
     * @param array<FailResult> &$failures Output parameter for fail results.
     * @param array<SkipResult> &$skips Output parameter for skip results.
     * @param array<WarningResult> &$warnings Output parameter for warning results.
     */
    public function testFunctions(
        DiscoveryResultInterface $discoveryResult,
        array &$passes,
        array &$failures,
        array &$skips,
        array &$warnings
    ): void {
        foreach ($discoveryResult->getFunctionNames() as $functionName) {
            try {
                $function = new ReflectionFunction($functionName);
                $args = $this->tokenGenerator->generateForParameters($function);
                $result = $function->invokeArgs($args);

                try {
                    $this->typeAsserter->assertMatches($result, $function->getReturnType());
                } catch (TypeMismatchException $e) {
                    throw new ReturnTypeMismatchException($functionName, $e);
                }

                $passes[] = new PassResult($functionName . '()');
            } catch (ReturnTypeMismatchException $e) {
                $failures[] = new FailResult($functionName . '()', $e->getMessage());
            } catch (Throwable $e) {
                $skips[] = new SkipResult($functionName . '()', $e->getMessage());
            }
        }
    }
}
