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
use PHPSure\Tests\Functional\Fixtures\MySimpleApp\CalculatorWithConstructorScenarios;

/**
 * Class CalculatorWithConstructorScenariosScanTest.
 *
 * Functional tests for scanning CalculatorWithConstructorScenarios.php.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class CalculatorWithConstructorScenariosScanTest extends AbstractFunctionalTestCase
{
    private RunnerInterface $runner;

    public function setUp(): void
    {
        $this->runner = (new Implementation())->getRunner();
    }

    public function testCalculatorWithConstructorScenariosAddPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/CalculatorWithConstructorScenarios.php');

        $methodResult = $result->getMethodResult(CalculatorWithConstructorScenarios::class, 'add');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\CalculatorWithConstructorScenarios->add() [add5]', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testCalculatorWithConstructorScenariosMultiplyPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/CalculatorWithConstructorScenarios.php');

        $methodResult = $result->getMethodResult(CalculatorWithConstructorScenarios::class, 'multiply');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\CalculatorWithConstructorScenarios->multiply() [multiply3]', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testCalculatorWithConstructorScenariosGetBasePasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/CalculatorWithConstructorScenarios.php');

        $methodResult = $result->getMethodResult(CalculatorWithConstructorScenarios::class, 'getBase');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\CalculatorWithConstructorScenarios->getBase()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testCalculatorWithConstructorScenariosGetBase5Passes(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/CalculatorWithConstructorScenarios.php');

        $methodResult = $result->getMethodResult(CalculatorWithConstructorScenarios::class, 'getBase5');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\CalculatorWithConstructorScenarios->getBase5() [getBase5]', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }
}
