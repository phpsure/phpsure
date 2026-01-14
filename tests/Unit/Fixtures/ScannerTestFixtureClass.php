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

namespace PHPSure\Tests\Unit\Fixtures;

/**
 * Class ScannerTestFixtureClass.
 *
 * Fixture class for testing Scanner.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ScannerTestFixtureClass
{
    public function __construct()
    {
    }

    public function publicInstanceMethod(): void
    {
    }

    public static function publicStaticMethod(): void
    {
    }

    private function privateInstanceMethod(): void
    {
    }

    private static function privateStaticMethod(): void
    {
    }
}
