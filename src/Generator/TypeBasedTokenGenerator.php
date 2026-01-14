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

namespace PHPSure\Generator;

use ReflectionClass;
use ReflectionNamedType;
use ReflectionUnionType;
use RuntimeException;
use Throwable;

/**
 * Class TypeBasedTokenGenerator.
 *
 * Generates tokens based on reflection types.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class TypeBasedTokenGenerator implements TypeBasedTokenGeneratorInterface
{
    public function __construct(
        private readonly FixtureResolverInterface $fixtureResolver,
        private readonly FixtureMaterialiserInterface $fixtureMaterialiser,
        private readonly ParameterResolverInterface $parameterResolver
    ) {
    }

    /**
     * @inheritDoc
     */
    public function generateForClassType(
        string $className,
        array $scenarioRefs,
        TokenGeneratorInterface $tokenGenerator
    ): object {
        $reflection = new ReflectionClass($className);

        // Check if there's a scenario reference for this parameter.
        foreach ($scenarioRefs as $scenarioRef) {
            if (is_array($scenarioRef) && isset($scenarioRef['fixture'])) {
                [$refClassName, $fixtureName] = $scenarioRef['fixture'];

                if ($refClassName === $className) {
                    return $this->fixtureMaterialiser->materialiseFixture($className, $fixtureName);
                }
            }
        }

        // Try to find an explicit 'default' fixture.
        $defaultFixture = $this->fixtureResolver->findDefaultFixture($reflection);

        if ($defaultFixture !== null) {
            return $this->fixtureMaterialiser->materialiseFixture(
                $className,
                $defaultFixture['name']
            );
        }

        // Check if constructor is private.
        $constructor = $reflection->getConstructor();
        $hasPrivateConstructor = $constructor !== null && !$constructor->isPublic();

        // If constructor is private and no default fixture, don't auto-generate.
        // This would be too magic and confusing.
        if ($hasPrivateConstructor) {
            throw new RuntimeException(
                sprintf(
                    'Cannot generate token for %s: private constructor requires explicit default fixture',
                    $className
                )
            );
        }

        // If concrete class with public zero-arg constructor, instantiate it.
        if (!$reflection->isAbstract() && !$reflection->isInterface()) {
            if ($constructor === null || ($constructor->isPublic() && $this->parameterResolver->hasNoRequiredParams($constructor))) {
                return new $className();
            }

            // Try to auto-generate constructor args if constructor is public.
            if ($constructor->isPublic()) {
                try {
                    $args = $tokenGenerator->generateForParameters($constructor);

                    return $reflection->newInstanceArgs($args);
                } catch (Throwable) {
                    // Could not auto-generate.
                }
            }
        }

        throw new RuntimeException(
            sprintf(
                'Cannot generate token for %s: needs fixture',
                $className
            )
        );
    }

    /**
     * @inheritDoc
     */
    public function generateForNamedType(
        ReflectionNamedType $type,
        array $scenarioRefs,
        TokenGeneratorInterface $tokenGenerator
    ): mixed {
        $typeName = $type->getName();

        // Handle nullable types - generate the non-null version.
        return $this->generateForTypeName($typeName, $scenarioRefs, $tokenGenerator);
    }

    /**
     * @inheritDoc
     */
    public function generateForTypeName(
        string $typeName,
        array $scenarioRefs,
        TokenGeneratorInterface $tokenGenerator
    ): mixed {
        return match ($typeName) {
            'int' => 101,
            'float' => 101.25,
            'string' => 'phpsure',
            'bool' => true,
            'array' => [],
            'mixed' => 'phpsure',
            default => $this->generateForClassType($typeName, $scenarioRefs, $tokenGenerator),
        };
    }

    /**
     * @inheritDoc
     */
    public function generateForUnionType(
        ReflectionUnionType $type,
        array $scenarioRefs,
        TokenGeneratorInterface $tokenGenerator
    ): mixed {
        $types = $type->getTypes();

        // Pick the first non-null arm deterministically.
        foreach ($types as $subType) {
            if ($subType->getName() !== 'null') {
                return $tokenGenerator->generateForType($subType, $scenarioRefs);
            }
        }

        // All types are null, use null.
        return null;
    }
}
