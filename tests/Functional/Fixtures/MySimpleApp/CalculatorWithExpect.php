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
 * Class CalculatorWithExpect.
 *
 * Calculator with scenarios that have expected return values.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class CalculatorWithExpect
{
    public function __construct(
        private readonly int $base
    ) {
    }

    #[Fixture('default', args: [10], expect: 'type check')]
    #[Fixture('base5', args: [5], expect: 'type check')]
    public static function create(int $base): self
    {
        return new self($base);
    }

    /**
     * Adds a value to the base.
     * Scenario with expected return value.
     */
    #[Scenario('add5', args: [5], expect: 15, instance: 'default')]
    public function add(int $value): int
    {
        return $this->base + $value;
    }

    /**
     * Multiplies the base by a value.
     * Scenario with expected return value.
     */
    #[Scenario('multiply2', args: [2], expect: 20, instance: 'default')]
    public function multiply(int $value): int
    {
        return $this->base * $value;
    }

    /**
     * Returns a greeting.
     * Scenario with expected string return value.
     */
    #[Scenario('greet', args: ['World'], expect: 'Hello, World!', instance: 'default')]
    public function greet(string $name): string
    {
        return "Hello, $name!";
    }

    /**
     * Checks if a number is even.
     * Scenario with expected boolean return value.
     */
    #[Scenario('isEven4', args: [4], expect: true, instance: 'default')]
    public function isEven(int $number): bool
    {
        return $number % 2 === 0;
    }

    /**
     * This method will fail the expect check.
     */
    #[Scenario('badExpect', args: [5], expect: 999, instance: 'default')]
    public function badExpect(int $value): int
    {
        return $this->base + $value;
    }
}
