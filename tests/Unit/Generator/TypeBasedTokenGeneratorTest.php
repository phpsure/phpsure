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

use Generator;
use Mockery\MockInterface;
use PHPSure\Generator\FixtureMaterialiserInterface;
use PHPSure\Generator\FixtureResolverInterface;
use PHPSure\Generator\ParameterResolverInterface;
use PHPSure\Generator\TokenGeneratorInterface;
use PHPSure\Generator\TypeBasedTokenGenerator;
use PHPSure\Tests\AbstractTestCase;
use ReflectionFunction;
use RuntimeException;

/**
 * Class TypeBasedTokenGeneratorTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class TypeBasedTokenGeneratorTest extends AbstractTestCase
{
    private MockInterface&FixtureResolverInterface $fixtureResolver;
    private MockInterface&FixtureMaterialiserInterface $fixtureMaterialiser;
    private MockInterface&ParameterResolverInterface $parameterResolver;
    private MockInterface&TokenGeneratorInterface $tokenGenerator;
    private TypeBasedTokenGenerator $typeBasedTokenGenerator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixtureResolver = mock(FixtureResolverInterface::class);
        $this->fixtureMaterialiser = mock(FixtureMaterialiserInterface::class);
        $this->parameterResolver = mock(ParameterResolverInterface::class);
        $this->tokenGenerator = mock(TokenGeneratorInterface::class);
        $this->typeBasedTokenGenerator = new TypeBasedTokenGenerator(
            $this->fixtureResolver,
            $this->fixtureMaterialiser,
            $this->parameterResolver
        );
    }

    /**
     * @dataProvider typeNameDataProvider
     */
    public function testGenerateForTypeNameReturnsExpectedValue(string $typeName, mixed $expectedValue): void
    {
        $result = $this->typeBasedTokenGenerator->generateForTypeName($typeName, [], $this->tokenGenerator);

        static::assertSame($expectedValue, $result);
    }

    public static function typeNameDataProvider(): Generator
    {
        yield 'int type' => ['int', 101];
        yield 'float type' => ['float', 101.25];
        yield 'string type' => ['string', 'phpsure'];
        yield 'bool type' => ['bool', true];
        yield 'array type' => ['array', []];
        yield 'mixed type' => ['mixed', 'phpsure'];
    }

    public function testGenerateForClassTypeThrowsForPrivateConstructorWithoutScenario(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Cannot generate token for PHPSure\Tests\Unit\Generator\ClassWithPrivateConstructor: private constructor requires explicit default fixture');

        $this->fixtureResolver->allows('findDefaultFixture')
            ->andReturn(null);

        $this->typeBasedTokenGenerator->generateForClassType(
            ClassWithPrivateConstructor::class,
            [],
            $this->tokenGenerator
        );
    }
}

/**
 * Test class with private constructor.
 */
class ClassWithPrivateConstructor
{
    private function __construct()
    {
    }
}
