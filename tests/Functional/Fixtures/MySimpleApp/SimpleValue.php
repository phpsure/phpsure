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
 * Class SimpleValue.
 *
 * A simple value object with a public constructor and no scenarios.
 * This demonstrates auto-generation of default factory scenarios.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class SimpleValue
{
    public function __construct(
        private readonly int $value
    ) {
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function double(): int
    {
        return $this->value * 2;
    }
}
