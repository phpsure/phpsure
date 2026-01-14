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
 * Class DirectoryScanTest.
 *
 * Functional tests for scanning an entire directory.
 * This provides integration test coverage for directory scanning.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class DirectoryScanTest extends AbstractFunctionalTestCase
{
    private RunnerInterface $runner;

    public function setUp(): void
    {
        $this->runner = (new Implementation())->getRunner();
    }

    public function testRunReturnsCorrectTotalsWhenScanningDirectory(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp');

        static::assertCount(61, $result->getPasses());
        static::assertCount(1, $result->getFailures()); // Only CalculatorWithExpect->badExpect().
        static::assertCount(2, $result->getWarnings());
        static::assertCount(0, $result->getSkips());
        static::assertSame(64, $result->getTotalCount());
    }
}
