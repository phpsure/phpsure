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

/**
 * Class Calculator.
 *
 * Simple calculator with static methods.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Calculator
{
    public static function add(int $a, int $b): int
    {
        return $a + $b;
    }

    public static function multiply(float $a, float $b): float
    {
        return $a * $b;
    }

    public static function isEven(int $number): bool
    {
        return $number % 2 === 0;
    }

    public static function greet(string $name): string
    {
        return "Hello, $name!";
    }
}
