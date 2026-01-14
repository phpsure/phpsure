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

namespace PHPSure\Tests\Functional\Fixtures;

/**
 * Class BadType.
 *
 * Fixture with a type mismatch to test failure detection.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class BadType
{
    public function returnsStringButReturnsInt(): string
    {
        return 42; // Type mismatch!
    }

    public function returnsIntButReturnsString(): int
    {
        return 'hello'; // Type mismatch!
    }
}
