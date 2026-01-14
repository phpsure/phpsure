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

namespace PHPSure\Tests\Unit\Runner;

use PHPSure\Runner\ExpectAsserter;
use PHPSure\Tests\AbstractTestCase;
use RuntimeException;

/**
 * Class ExpectAsserterTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ExpectAsserterTest extends AbstractTestCase
{
    private ExpectAsserter $expectAsserter;

    public function setUp(): void
    {
        $this->expectAsserter = new ExpectAsserter();
    }

    public function testAssertExpectPassesWhenResultMatchesExpect(): void
    {
        $this->expectAsserter->assertExpect(42, 42, 'MyClass::myMethod');

        $this->assertTrue(true); // If we get here, the assertion passed.
    }

    public function testAssertExpectPassesWhenResultMatchesExpectWithString(): void
    {
        $this->expectAsserter->assertExpect('hello', 'hello', 'MyClass::myMethod');

        $this->assertTrue(true); // If we get here, the assertion passed.
    }

    public function testAssertExpectPassesWhenResultMatchesExpectWithNull(): void
    {
        $this->expectAsserter->assertExpect(null, null, 'MyClass::myMethod');

        $this->assertTrue(true); // If we get here, the assertion passed.
    }

    public function testAssertExpectPassesWhenResultMatchesExpectWithBoolean(): void
    {
        $this->expectAsserter->assertExpect(true, true, 'MyClass::myMethod');

        $this->assertTrue(true); // If we get here, the assertion passed.
    }

    public function testAssertExpectThrowsWhenResultDoesNotMatchExpect(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Expected 42 but got 21");

        $this->expectAsserter->assertExpect(21, 42, 'MyClass::myMethod');
    }

    public function testAssertExpectThrowsWhenResultDoesNotMatchExpectWithString(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Expected 'world' but got 'hello'");

        $this->expectAsserter->assertExpect('hello', 'world', 'MyClass::myMethod');
    }

    public function testAssertExpectThrowsWhenResultDoesNotMatchExpectWithNull(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Expected NULL but got 42");

        $this->expectAsserter->assertExpect(42, null, 'MyClass::myMethod');
    }

    public function testAssertExpectThrowsWhenResultDoesNotMatchExpectWithBoolean(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Expected true but got false");

        $this->expectAsserter->assertExpect(false, true, 'MyClass::myMethod');
    }

    public function testAssertExpectThrowsWhenResultDoesNotMatchExpectWithArray(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Expected array (\n  0 => 1,\n  1 => 2,\n) but got array (\n  0 => 3,\n  1 => 4,\n)");

        $this->expectAsserter->assertExpect([3, 4], [1, 2], 'MyClass::myMethod');
    }

    public function testAssertExpectPassesWhenResultMatchesExpectWithArray(): void
    {
        $this->expectAsserter->assertExpect([1, 2], [1, 2], 'MyClass::myMethod');

        $this->assertTrue(true); // If we get here, the assertion passed.
    }
}
