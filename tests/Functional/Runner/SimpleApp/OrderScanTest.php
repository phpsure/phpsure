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
use PHPSure\Tests\Functional\Fixtures\MySimpleApp\Order;

/**
 * Class OrderScanTest.
 *
 * Functional tests for scanning Order.php.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class OrderScanTest extends AbstractFunctionalTestCase
{
    private RunnerInterface $runner;

    public function setUp(): void
    {
        $this->runner = (new Implementation())->getRunner();
    }

    public function testOrderCreateDefaultPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Order.php');

        $methodResult = $result->getMethodResult(Order::class, 'create');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Order::create() [default]', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testOrderGetUserPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Order.php');

        $methodResult = $result->getMethodResult(Order::class, 'getUser');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Order->getUser()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testOrderGetTotalPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Order.php');

        $methodResult = $result->getMethodResult(Order::class, 'getTotal');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Order->getTotal()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testOrderGetTotalPoundsPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Order.php');

        $methodResult = $result->getMethodResult(Order::class, 'getTotalPounds');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Order->getTotalPounds()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testOrderIsHighValuePasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Order.php');

        $methodResult = $result->getMethodResult(Order::class, 'isHighValue');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Order->isHighValue()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }
}
