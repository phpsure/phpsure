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

namespace PHPSure\Tests\Unit\Implementation;

use PHPSure\Bin\PhpSureBinary;
use PHPSure\Implementation\Implementation;
use PHPSure\Tests\AbstractTestCase;

/**
 * Class ImplementationTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ImplementationTest extends AbstractTestCase
{
    private Implementation $implementation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->implementation = new Implementation();
    }

    public function testGetPhpSureBinaryReturnsPhpSureInstance(): void
    {
        $phpSureBinary = $this->implementation->getPhpSureBinary();

        static::assertInstanceOf(PhpSureBinary::class, $phpSureBinary);
    }

    public function testGetPhpSureBinaryReturnsSameInstanceOnSubsequentCalls(): void
    {
        $phpSureBinary1 = $this->implementation->getPhpSureBinary();
        $phpSureBinary2 = $this->implementation->getPhpSureBinary();

        static::assertSame($phpSureBinary1, $phpSureBinary2);
    }
}
