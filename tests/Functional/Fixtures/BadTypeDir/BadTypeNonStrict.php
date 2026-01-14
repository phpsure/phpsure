<?php

/*
 * PHPSure
 * Copyright (c) Dan Phillimore (asmblah)
 * https://github.com/phpsure/phpsure/
 *
 * Released under the MIT license.
 * https://github.com/phpsure/phpsure/raw/main/MIT-LICENSE.txt
 */

namespace PHPSure\Tests\Functional\Fixtures\BadTypeDir;

/**
 * Class BadTypeNonStrict.
 *
 * Fixture with a type mismatch to test failure detection (non-strict).
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class BadTypeNonStrict
{
    public function returnsStringButReturnsInt(): string
    {
        return 42; // Type mismatch!
    }
}
