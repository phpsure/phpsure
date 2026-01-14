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

namespace MyConfiguredApp;

/**
 * Class Calculator.
 *
 * A simple calculator for testing.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Calculator
{
    /**
     * Adds two numbers.
     */
    public function add(int $a, int $b): int
    {
        return $a + $b;
    }

    /**
     * Multiplies two numbers.
     */
    public function multiply(int $a, int $b): int
    {
        return $a * $b;
    }

    /**
     * Checks if a number is even.
     */
    public function isEven(int $number): bool
    {
        return $number % 2 === 0;
    }
}
