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
 * Global functions for testing.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */

function double(int $number): int
{
    return $number * 2;
}

function formatPrice(float $price): string
{
    return '£' . number_format($price, 2);
}

function isPositive(int $number): bool
{
    return $number > 0;
}

function getDefaultValue(): string
{
    return 'default';
}
