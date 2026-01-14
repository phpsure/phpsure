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
use PHPSure\Tests\Functional\Fixtures\MySimpleApp\Money;

/**
 * Class MoneyScanTest.
 *
 * Functional tests for scanning Money.php.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class MoneyScanTest extends AbstractFunctionalTestCase
{
    private RunnerInterface $runner;

    public function setUp(): void
    {
        $this->runner = (new Implementation())->getRunner();
    }

    public function testMoneyFromIntDefaultPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Money.php');

        $methodResult = $result->getMethodResult(Money::class, 'fromInt');
        $passes = $methodResult->getPasses();

        static::assertCount(3, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Money::fromInt() [default]', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testMoneyFromIntGbp10Passes(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Money.php');

        $methodResult = $result->getMethodResult(Money::class, 'fromInt');
        $passes = $methodResult->getPasses();

        static::assertCount(3, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Money::fromInt() [gbp10]', $passes[1]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testMoneyFromIntGbp5Passes(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Money.php');

        $methodResult = $result->getMethodResult(Money::class, 'fromInt');
        $passes = $methodResult->getPasses();

        static::assertCount(3, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Money::fromInt() [gbp5]', $passes[2]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testMoneyGetPencePasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Money.php');

        $methodResult = $result->getMethodResult(Money::class, 'getPence');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Money->getPence()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testMoneyGetPoundsPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Money.php');

        $methodResult = $result->getMethodResult(Money::class, 'getPounds');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Money->getPounds()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testMoneyAddPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Money.php');

        $methodResult = $result->getMethodResult(Money::class, 'add');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Money->add()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testMoneyIsGreaterThanPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Money.php');

        $methodResult = $result->getMethodResult(Money::class, 'isGreaterThan');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Money->isGreaterThan()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }
}
