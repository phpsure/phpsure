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
use PHPSure\Tests\Functional\Fixtures\MySimpleApp\CalculatorWithExpect;

/**
 * Class CalculatorWithExpectScanTest.
 *
 * Functional tests for scanning CalculatorWithExpect.php.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class CalculatorWithExpectScanTest extends AbstractFunctionalTestCase
{
    private RunnerInterface $runner;

    public function setUp(): void
    {
        $this->runner = (new Implementation())->getRunner();
    }

    public function testCalculatorWithExpectCreateDefaultPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/CalculatorWithExpect.php');

        $methodResult = $result->getMethodResult(CalculatorWithExpect::class, 'create');
        $passes = $methodResult->getPasses();

        static::assertCount(2, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\CalculatorWithExpect::create() [default]', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testCalculatorWithExpectCreateBase5Passes(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/CalculatorWithExpect.php');

        $methodResult = $result->getMethodResult(CalculatorWithExpect::class, 'create');
        $passes = $methodResult->getPasses();

        static::assertCount(2, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\CalculatorWithExpect::create() [base5]', $passes[1]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testCalculatorWithExpectAddPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/CalculatorWithExpect.php');

        $methodResult = $result->getMethodResult(CalculatorWithExpect::class, 'add');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\CalculatorWithExpect->add() [add5]', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testCalculatorWithExpectMultiplyPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/CalculatorWithExpect.php');

        $methodResult = $result->getMethodResult(CalculatorWithExpect::class, 'multiply');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\CalculatorWithExpect->multiply() [multiply2]', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testCalculatorWithExpectGreetPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/CalculatorWithExpect.php');

        $methodResult = $result->getMethodResult(CalculatorWithExpect::class, 'greet');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\CalculatorWithExpect->greet() [greet]', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testCalculatorWithExpectIsEvenPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/CalculatorWithExpect.php');

        $methodResult = $result->getMethodResult(CalculatorWithExpect::class, 'isEven');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\CalculatorWithExpect->isEven() [isEven4]', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testCalculatorWithExpectBadExpectFails(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/CalculatorWithExpect.php');

        $methodResult = $result->getMethodResult(CalculatorWithExpect::class, 'badExpect');
        $failures = $methodResult->getFailures();

        static::assertCount(1, $failures);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\CalculatorWithExpect->badExpect() [badExpect]', $failures[0]->identifier);
        static::assertStringContainsString('Expected 999 but got 15', $failures[0]->message);
    }
}
