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
use PHPSure\Tests\Functional\Fixtures\MySimpleApp\MoneyWithScenarios;

/**
 * Class MoneyWithScenariosScanTest.
 *
 * Functional tests for scanning MoneyWithScenarios.php.
 * Tests instance methods with class-typed parameters using explicit scenarios.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class MoneyWithScenariosScanTest extends AbstractFunctionalTestCase
{
    private RunnerInterface $runner;

    public function setUp(): void
    {
        $this->runner = (new Implementation())->getRunner();
    }

    public function testMoneyWithScenariosFromIntDefaultPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/MoneyWithScenarios.php');

        $methodResult = $result->getMethodResult(MoneyWithScenarios::class, 'fromInt');
        $passes = $methodResult->getPasses();

        static::assertCount(4, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\MoneyWithScenarios::fromInt() [default]', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testMoneyWithScenariosFromIntGbp10Passes(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/MoneyWithScenarios.php');

        $methodResult = $result->getMethodResult(MoneyWithScenarios::class, 'fromInt');
        $passes = $methodResult->getPasses();

        static::assertCount(4, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\MoneyWithScenarios::fromInt() [gbp10]', $passes[1]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testMoneyWithScenariosFromIntGbp5Passes(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/MoneyWithScenarios.php');

        $methodResult = $result->getMethodResult(MoneyWithScenarios::class, 'fromInt');
        $passes = $methodResult->getPasses();

        static::assertCount(4, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\MoneyWithScenarios::fromInt() [gbp5]', $passes[2]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testMoneyWithScenariosFromIntGbp20Passes(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/MoneyWithScenarios.php');

        $methodResult = $result->getMethodResult(MoneyWithScenarios::class, 'fromInt');
        $passes = $methodResult->getPasses();

        static::assertCount(4, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\MoneyWithScenarios::fromInt() [gbp20]', $passes[3]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testMoneyWithScenariosGetPencePasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/MoneyWithScenarios.php');

        $methodResult = $result->getMethodResult(MoneyWithScenarios::class, 'getPence');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\MoneyWithScenarios->getPence()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testMoneyWithScenariosGetPoundsPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/MoneyWithScenarios.php');

        $methodResult = $result->getMethodResult(MoneyWithScenarios::class, 'getPounds');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\MoneyWithScenarios->getPounds()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testMoneyWithScenariosAddGbp5ToGbp10Passes(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/MoneyWithScenarios.php');

        $methodResult = $result->getMethodResult(MoneyWithScenarios::class, 'add');
        $passes = $methodResult->getPasses();

        static::assertCount(2, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\MoneyWithScenarios->add() [add_gbp5_to_gbp10]', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testMoneyWithScenariosAddGbp10ToGbp5Passes(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/MoneyWithScenarios.php');

        $methodResult = $result->getMethodResult(MoneyWithScenarios::class, 'add');
        $passes = $methodResult->getPasses();

        static::assertCount(2, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\MoneyWithScenarios->add() [add_gbp10_to_gbp5]', $passes[1]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testMoneyWithScenariosIsGreaterThanGbp10GreaterThanGbp5Passes(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/MoneyWithScenarios.php');

        $methodResult = $result->getMethodResult(MoneyWithScenarios::class, 'isGreaterThan');
        $passes = $methodResult->getPasses();

        static::assertCount(2, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\MoneyWithScenarios->isGreaterThan() [gbp10_greater_than_gbp5]', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testMoneyWithScenariosIsGreaterThanGbp5NotGreaterThanGbp10Passes(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/MoneyWithScenarios.php');

        $methodResult = $result->getMethodResult(MoneyWithScenarios::class, 'isGreaterThan');
        $passes = $methodResult->getPasses();

        static::assertCount(2, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\MoneyWithScenarios->isGreaterThan() [gbp5_not_greater_than_gbp10]', $passes[1]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }
}
