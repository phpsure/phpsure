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
 * Class ScannerTestAbstractFixtureClass.
 *
 * Abstract fixture class for testing Scanner.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
abstract class ScannerTestAbstractFixtureClass
{
    abstract public function abstractMethod(): void;

    abstract public static function abstractStaticMethod(): void;

    public function concreteMethod(): void
    {
    }
}
