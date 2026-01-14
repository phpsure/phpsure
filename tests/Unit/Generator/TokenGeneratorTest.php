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

namespace PHPSure\Tests\Unit\Generator;

use Mockery\MockInterface;
use PHPSure\Generator\TokenGenerator;
use PHPSure\Generator\TypeBasedTokenGeneratorInterface;
use PHPSure\Tests\AbstractTestCase;
use ReflectionNamedType;

/**
 * Class TokenGeneratorTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class TokenGeneratorTest extends AbstractTestCase
{
    private TypeBasedTokenGeneratorInterface&MockInterface $typeBasedTokenGenerator;
    private TokenGenerator $tokenGenerator;

    public function setUp(): void
    {
        $this->typeBasedTokenGenerator = mock(TypeBasedTokenGeneratorInterface::class);
        $this->tokenGenerator = new TokenGenerator($this->typeBasedTokenGenerator);
    }

    public function testGenerateForTypeReturnsIntForIntType(): void
    {
        $type = $this->createMockNamedType('int');

        $this->typeBasedTokenGenerator->expects('generateForNamedType')
            ->once()
            ->with($type, [], $this->tokenGenerator)
            ->andReturn(101);

        $result = $this->tokenGenerator->generateForType($type);

        static::assertSame(101, $result);
    }

    public function testGenerateForTypeReturnsFloatForFloatType(): void
    {
        $type = $this->createMockNamedType('float');

        $this->typeBasedTokenGenerator->expects('generateForNamedType')
            ->once()
            ->with($type, [], $this->tokenGenerator)
            ->andReturn(101.25);

        $result = $this->tokenGenerator->generateForType($type);

        static::assertSame(101.25, $result);
    }

    public function testGenerateForTypeReturnsStringForStringType(): void
    {
        $type = $this->createMockNamedType('string');

        $this->typeBasedTokenGenerator->expects('generateForNamedType')
            ->once()
            ->with($type, [], $this->tokenGenerator)
            ->andReturn('phpsure');

        $result = $this->tokenGenerator->generateForType($type);

        static::assertSame('phpsure', $result);
    }

    public function testGenerateForTypeReturnsBoolForBoolType(): void
    {
        $type = $this->createMockNamedType('bool');

        $this->typeBasedTokenGenerator->expects('generateForNamedType')
            ->once()
            ->with($type, [], $this->tokenGenerator)
            ->andReturn(true);

        $result = $this->tokenGenerator->generateForType($type);

        static::assertTrue($result);
    }

    public function testGenerateForTypeReturnsEmptyArrayForArrayType(): void
    {
        $type = $this->createMockNamedType('array');

        $this->typeBasedTokenGenerator->expects('generateForNamedType')
            ->once()
            ->with($type, [], $this->tokenGenerator)
            ->andReturn([]);

        $result = $this->tokenGenerator->generateForType($type);

        static::assertSame([], $result);
    }

    public function testGenerateForTypeReturnsNullForNullType(): void
    {
        $result = $this->tokenGenerator->generateForType(null);

        static::assertNull($result);
    }

    public function testGenerateForTypeReturnsNonNullableValueForNullableType(): void
    {
        $type = $this->createMockNamedType('int', allowsNull: true);

        $this->typeBasedTokenGenerator->expects('generateForNamedType')
            ->once()
            ->with($type, [], $this->tokenGenerator)
            ->andReturn(101);

        $result = $this->tokenGenerator->generateForType($type);

        static::assertSame(101, $result);
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
