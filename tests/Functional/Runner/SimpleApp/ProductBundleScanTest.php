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
use PHPSure\Tests\Functional\Fixtures\MySimpleApp\ProductBundle;

/**
 * Class ProductBundleScanTest.
 *
 * Functional tests for scanning ProductBundle.php.
 * Tests constructor with promoted properties typed as classes requiring auto-generated scenarios.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ProductBundleScanTest extends AbstractFunctionalTestCase
{
    private RunnerInterface $runner;

    public function setUp(): void
    {
        $this->runner = (new Implementation())->getRunner();
    }

    public function testProductBundleGetProduct1Passes(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/ProductBundle.php');

        $methodResult = $result->getMethodResult(ProductBundle::class, 'getProduct1');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\ProductBundle->getProduct1()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testProductBundleGetProduct2Passes(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/ProductBundle.php');

        $methodResult = $result->getMethodResult(ProductBundle::class, 'getProduct2');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\ProductBundle->getProduct2()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testProductBundleGetTotalPricePasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/ProductBundle.php');

        $methodResult = $result->getMethodResult(ProductBundle::class, 'getTotalPrice');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\ProductBundle->getTotalPrice()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testProductBundleIsTotalAbovePasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/ProductBundle.php');

        $methodResult = $result->getMethodResult(ProductBundle::class, 'isTotalAbove');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\ProductBundle->isTotalAbove()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }
}
