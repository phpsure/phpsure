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

use PHPSure\Exception\ReturnTypeMismatchException;
use PHPSure\Exception\TypeMismatchException;
use PHPSure\Tests\AbstractTestCase;
use ReflectionNamedType;

/**
 * Class ReturnTypeMismatchExceptionTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ReturnTypeMismatchExceptionTest extends AbstractTestCase
{
    public function testConstructorSetsMessageWithPreviousException(): void
    {
        $mockType = mock(ReflectionNamedType::class);
        $mockType->allows('allowsNull')->andReturn(false);
        $mockType->allows('__toString')->andReturn('string');

        $previousException = new TypeMismatchException('wrong value', $mockType);
        $exception = new ReturnTypeMismatchException('MyClass::myMethod', $previousException);

        $this->assertStringContainsString('Return type mismatch for MyClass::myMethod', $exception->getMessage());
        $this->assertStringContainsString('Type mismatch', $exception->getMessage());
        $this->assertSame($previousException, $exception->getPrevious());
    }

    public function testConstructorSetsMessageWithoutPreviousException(): void
    {
        $exception = new ReturnTypeMismatchException('MyClass::myMethod');

        $this->assertStringContainsString('Return type mismatch for MyClass::myMethod', $exception->getMessage());
        $this->assertStringContainsString('type mismatch', $exception->getMessage());
        $this->assertNull($exception->getPrevious());
    }

    public function testConstructorSetsMessageForFunction(): void
    {
        $mockType = mock(ReflectionNamedType::class);
        $mockType->allows('allowsNull')->andReturn(false);
        $mockType->allows('__toString')->andReturn('int');

        $previousException = new TypeMismatchException('not an int', $mockType);
        $exception = new ReturnTypeMismatchException('myFunction', $previousException);

        $this->assertStringContainsString('Return type mismatch for myFunction', $exception->getMessage());
        $this->assertSame($previousException, $exception->getPrevious());
    }
}
