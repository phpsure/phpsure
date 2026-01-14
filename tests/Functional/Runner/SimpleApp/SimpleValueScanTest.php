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
use PHPSure\Tests\Functional\Fixtures\MySimpleApp\SimpleValue;

/**
 * Class SimpleValueScanTest.
 *
 * Functional tests for scanning SimpleValue.php.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class SimpleValueScanTest extends AbstractFunctionalTestCase
{
    private RunnerInterface $runner;

    public function setUp(): void
    {
        $this->runner = (new Implementation())->getRunner();
    }

    public function testSimpleValueGetValuePasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/SimpleValue.php');

        $methodResult = $result->getMethodResult(SimpleValue::class, 'getValue');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\SimpleValue->getValue()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getWarnings());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testSimpleValueDoublePasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/SimpleValue.php');

        $methodResult = $result->getMethodResult(SimpleValue::class, 'double');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\SimpleValue->double()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getWarnings());
        static::assertEmpty($methodResult->getSkips());
    }
}
