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

namespace PHPSure\Tests\Functional\Runner\SimpleApp;

use PHPSure\Implementation\Implementation;
use PHPSure\Runner\RunnerInterface;
use PHPSure\Tests\Functional\AbstractFunctionalTestCase;
use PHPSure\Tests\Functional\Fixtures\MySimpleApp\Calculator;

/**
 * Class CalculatorScanTest.
 *
 * Functional tests for scanning Calculator.php.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class CalculatorScanTest extends AbstractFunctionalTestCase
{
    private RunnerInterface $runner;

    public function setUp(): void
    {
        $this->runner = (new Implementation())->getRunner();
    }

    public function testCalculatorAddPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Calculator.php');

        $methodResult = $result->getMethodResult(Calculator::class, 'add');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Calculator::add()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testCalculatorMultiplyPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Calculator.php');

        $methodResult = $result->getMethodResult(Calculator::class, 'multiply');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Calculator::multiply()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testCalculatorIsEvenPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Calculator.php');

        $methodResult = $result->getMethodResult(Calculator::class, 'isEven');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Calculator::isEven()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testCalculatorGreetPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Calculator.php');

        $methodResult = $result->getMethodResult(Calculator::class, 'greet');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Calculator::greet()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }
}
