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
 * Greets a person.
 */
function greet(string $name): string
{
    return 'Hello, ' . $name . '!';
}

/**
 * Doubles a number.
 */
function double(int $number): int
{
    return $number * 2;
}
