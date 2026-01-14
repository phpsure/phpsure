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

namespace PHPSure\Tests\Unit\Assert;

use PHPSure\Assert\TypeAsserter;
use PHPSure\Exception\TypeMismatchException;
use PHPSure\Tests\AbstractTestCase;
use ReflectionNamedType;

/**
 * Class TypeAsserterTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class TypeAsserterTest extends AbstractTestCase
{
    private TypeAsserter $typeAsserter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->typeAsserter = new TypeAsserter();
    }

    public function testAssertMatchesPassesForMatchingInt(): void
    {
        $type = $this->createMockNamedType('int');

        $this->typeAsserter->assertMatches(42, $type);

        // No exception thrown.
        $this->assertTrue(true);
    }

    public function testAssertMatchesThrowsForMismatchedInt(): void
    {
        $type = $this->createMockNamedType('int');

        $this->expectException(TypeMismatchException::class);

        $this->typeAsserter->assertMatches('not an int', $type);
    }

    public function testAssertMatchesPassesForMatchingString(): void
    {
        $type = $this->createMockNamedType('string');

        $this->typeAsserter->assertMatches('hello', $type);

        // No exception thrown.
        $this->assertTrue(true);
    }

    public function testAssertMatchesPassesForNullableIntWithNull(): void
    {
        $type = $this->createMockNamedType('int', allowsNull: true);

        $this->typeAsserter->assertMatches(null, $type);

        // No exception thrown.
        $this->assertTrue(true);
    }

    public function testAssertMatchesPassesForVoidWithNull(): void
    {
        $type = $this->createMockNamedType('void');

        $this->typeAsserter->assertMatches(null, $type);

        // No exception thrown.
        $this->assertTrue(true);
    }

    public function testAssertMatchesThrowsForVoidWithNonNull(): void
    {
        $type = $this->createMockNamedType('void');

        $this->expectException(TypeMismatchException::class);

        $this->typeAsserter->assertMatches('not null', $type);
    }



    /**
     * Creates a mock ReflectionNamedType.
     *
     * @param string $typeName The type name.
     * @param bool $allowsNull Whether the type allows null.
     * @return mixed The mocked type.
     */
    private function createMockNamedType(string $typeName, bool $allowsNull = false): mixed
    {
        $type = mock(ReflectionNamedType::class);
        $type->allows('getName')
            ->andReturn($typeName);
        $type->allows('allowsNull')
            ->andReturn($allowsNull);

        return $type;
    }
}
