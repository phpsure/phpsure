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

/**
 * Class FunctionsScanTest.
 *
 * Functional tests for scanning functions.php.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class FunctionsScanTest extends AbstractFunctionalTestCase
{
    private RunnerInterface $runner;

    public function setUp(): void
    {
        $this->runner = (new Implementation())->getRunner();
    }

    public function testFunctionDoublePasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/functions.php');

        $functionResult = $result->getFunctionResult('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\double');

        $passes = $functionResult->getPasses();
        static::assertCount(1, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\double()', $passes[0]->identifier);
        static::assertEmpty($functionResult->getFailures());
        static::assertEmpty($functionResult->getSkips());
    }

    public function testFunctionFormatPricePasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/functions.php');

        $functionResult = $result->getFunctionResult('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\formatPrice');

        $passes = $functionResult->getPasses();
        static::assertCount(1, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\formatPrice()', $passes[0]->identifier);
        static::assertEmpty($functionResult->getFailures());
        static::assertEmpty($functionResult->getSkips());
    }

    public function testFunctionIsPositivePasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/functions.php');

        $functionResult = $result->getFunctionResult('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\isPositive');

        $passes = $functionResult->getPasses();
        static::assertCount(1, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\isPositive()', $passes[0]->identifier);
        static::assertEmpty($functionResult->getFailures());
        static::assertEmpty($functionResult->getSkips());
    }

    public function testFunctionGetDefaultValuePasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/functions.php');

        $functionResult = $result->getFunctionResult('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\getDefaultValue');

        $passes = $functionResult->getPasses();
        static::assertCount(1, $passes);
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\getDefaultValue()', $passes[0]->identifier);
        static::assertEmpty($functionResult->getFailures());
        static::assertEmpty($functionResult->getSkips());
    }
}
