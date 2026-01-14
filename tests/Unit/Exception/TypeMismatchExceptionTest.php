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

namespace PHPSure\Tests\Unit\Exception;

use PHPSure\Exception\TypeMismatchException;
use PHPSure\Tests\AbstractTestCase;
use ReflectionNamedType;

/**
 * Class TypeMismatchExceptionTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class TypeMismatchExceptionTest extends AbstractTestCase
{
    public function testConstructorSetsMessageForNonNullableType(): void
    {
        $mockType = mock(ReflectionNamedType::class);
        $mockType->allows('allowsNull')->andReturn(false);
        $mockType->allows('__toString')->andReturn('string');

        $exception = new TypeMismatchException(123, $mockType);

        $this->assertStringContainsString('Type mismatch: expected string but got int', $exception->getMessage());
    }

    public function testConstructorSetsMessageForNullableType(): void
    {
        $mockType = mock(ReflectionNamedType::class);
        $mockType->allows('allowsNull')->andReturn(true);
        $mockType->allows('__toString')->andReturn('int');

        $exception = new TypeMismatchException('not an int', $mockType);

        $this->assertStringContainsString('Type mismatch: expected ?int but got string', $exception->getMessage());
    }

    public function testConstructorSetsMessageForObjectType(): void
    {
        $mockType = mock(ReflectionNamedType::class);
        $mockType->allows('allowsNull')->andReturn(false);
        $mockType->allows('__toString')->andReturn('stdClass');

        $exception = new TypeMismatchException([], $mockType);

        $this->assertStringContainsString('Type mismatch: expected stdClass but got array', $exception->getMessage());
    }

    public function testConstructorSetsMessageForNullValue(): void
    {
        $mockType = mock(ReflectionNamedType::class);
        $mockType->allows('allowsNull')->andReturn(false);
        $mockType->allows('__toString')->andReturn('string');

        $exception = new TypeMismatchException(null, $mockType);

        $this->assertStringContainsString('Type mismatch: expected string but got null', $exception->getMessage());
    }
}
