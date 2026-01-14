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

namespace PHPSure\Tests\Functional\Fixtures\MySimpleApp;

use PHPSure\Attributes\Fixture;
use PHPSure\Attributes\Scenario;

/**
 * Class CalculatorWithConstructorScenarios.
 *
 * Calculator with fixtures defined on the constructor.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class CalculatorWithConstructorScenarios
{
    #[Fixture('default', args: [10])]
    #[Fixture('base5', args: [5])]
    public function __construct(
        private readonly int $base
    ) {
    }

    /**
     * Adds a value to the base.
     * Scenario with expected return value using 'default' constructor fixture.
     */
    #[Scenario('add5', args: [5], expect: 15, instance: 'default')]
    public function add(int $value): int
    {
        return $this->base + $value;
    }

    /**
     * Multiplies the base by a value.
     * Scenario with expected return value using 'base5' constructor fixture.
     */
    #[Scenario('multiply3', args: [3], expect: 15, instance: 'base5')]
    public function multiply(int $value): int
    {
        return $this->base * $value;
    }

    /**
     * Returns the base value.
     * Scenario with expected return value using 'default' constructor fixture.
     * Scenario description is optional - defaults to null.
     */
    #[Scenario(args: [], expect: 10)]
    public function getBase(): int
    {
        return $this->base;
    }

    /**
     * Returns the base value from base5 fixture.
     * Scenario with expected return value using 'base5' constructor fixture.
     */
    #[Scenario('getBase5', args: [], expect: 5, instance: 'base5')]
    public function getBase5(): int
    {
        return $this->base;
    }
}
