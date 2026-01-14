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
use PHPSure\Tests\Functional\Fixtures\MySimpleApp\Currency;

/**
 * Class CurrencyScanTest.
 *
 * Functional tests for scanning Currency.php.
 * Tests the warning behavior when a class has a private constructor,
 * static factory methods, but no 'default' scenario.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class CurrencyScanTest extends AbstractFunctionalTestCase
{
    private RunnerInterface $runner;

    public function setUp(): void
    {
        $this->runner = (new Implementation())->getRunner();
    }

    /**
     * Tests that Currency::fromCode scenarios pass.
     */
    public function testCurrencyFromCodeUsdPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Currency.php');

        $methodResult = $result->getMethodResult(Currency::class, 'fromCode');

        $passes = $methodResult->getPasses();
        static::assertCount(3, $passes, 'Expected 3 passes for Currency::fromCode (usd, gbp, eur)');
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Currency::fromCode() [usd]', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
        static::assertEmpty($methodResult->getWarnings());
    }

    public function testCurrencyFromCodeGbpPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Currency.php');

        $methodResult = $result->getMethodResult(Currency::class, 'fromCode');

        $passes = $methodResult->getPasses();
        static::assertCount(3, $passes, 'Expected 3 passes for Currency::fromCode (usd, gbp, eur)');
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Currency::fromCode() [gbp]', $passes[1]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
        static::assertEmpty($methodResult->getWarnings());
    }

    public function testCurrencyFromCodeEurPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Currency.php');

        $methodResult = $result->getMethodResult(Currency::class, 'fromCode');

        $passes = $methodResult->getPasses();
        static::assertCount(3, $passes, 'Expected 3 passes for Currency::fromCode (usd, gbp, eur)');
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Currency::fromCode() [eur]', $passes[2]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
        static::assertEmpty($methodResult->getWarnings());
    }

    /**
     * Tests that Currency->getCode() generates a WARNING.
     * This is because:
     * - getCode() is an instance method that needs a Currency instance
     * - Currency has a private constructor
     * - Currency has static factory methods but NO 'default' scenario
     * - Therefore, auto-generation cannot safely proceed and should warn
     */
    public function testCurrencyGetCodeGeneratesWarning(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Currency.php');

        $methodResult = $result->getMethodResult(Currency::class, 'getCode');

        $warnings = $methodResult->getWarnings();
        static::assertCount(1, $warnings, 'Expected exactly 1 warning for Currency->getCode()');
        $warning = $warnings[0];
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Currency->getCode()', $warning->identifier);
        static::assertSame('Cannot create instance for testing - private constructor requires explicit factory scenario', $warning->message);
        static::assertEmpty($methodResult->getPasses(), 'Should not have passes for Currency->getCode()');
        static::assertEmpty($methodResult->getFailures(), 'Should not have failures for Currency->getCode()');
        static::assertEmpty($methodResult->getSkips(), 'Should not have skips for Currency->getCode()');
    }

    /**
     * Tests that Currency->isSameCurrency() generates a WARNING.
     * This is because:
     * - isSameCurrency() has a Currency parameter that needs auto-generation
     * - Currency has a private constructor
     * - Currency has static factory methods but NO 'default' scenario
     * - Therefore, auto-generation cannot safely proceed and should warn
     */
    public function testCurrencyIsSameCurrencyGeneratesWarning(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/Currency.php');

        $methodResult = $result->getMethodResult(Currency::class, 'isSameCurrency');

        $warnings = $methodResult->getWarnings();
        static::assertCount(1, $warnings, 'Expected exactly 1 warning for Currency->isSameCurrency()');
        $warning = $warnings[0];
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Currency->isSameCurrency()', $warning->identifier);
        static::assertSame('Cannot create instance for testing - private constructor requires explicit factory scenario', $warning->message);
        static::assertEmpty($methodResult->getPasses(), 'Should not have passes for Currency->isSameCurrency()');
        static::assertEmpty($methodResult->getFailures(), 'Should not have failures for Currency->isSameCurrency()');
        static::assertEmpty($methodResult->getSkips(), 'Should not have skips for Currency->isSameCurrency()');
    }
}
