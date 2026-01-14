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
use PHPSure\Tests\Functional\Fixtures\MySimpleApp\CalculatorMissingDefaultFixture;

/**
 * Class CalculatorMissingDefaultFixtureScanTest.
 *
 * Functional tests for scanning CalculatorMissingDefaultFixture.php.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class CalculatorMissingDefaultFixtureScanTest extends AbstractFunctionalTestCase
{
    private RunnerInterface $runner;

    public function setUp(): void
    {
        $this->runner = (new Implementation())->getRunner();
    }

    public function testCalculatorMissingDefaultFixtureFallsBackToFirstFixture(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/CalculatorMissingDefaultFixture.php');

        // The add method should pass because even though there's no 'default' constructor fixture,
        // the public constructor allows auto-generation using the first available fixture ('base5').
        $passes = $result->getPasses();
        $addPass = array_filter($passes, fn ($pass) => str_contains($pass->identifier, 'add'));

        static::assertCount(1, $addPass);
        static::assertSame(CalculatorMissingDefaultFixture::class . '->add()', $addPass[0]->identifier);
    }
}
