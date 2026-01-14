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

use ReflectionException;
use ReflectionNamedType;
use ReflectionUnionType;

/**
 * Interface TypeBasedTokenGeneratorInterface.
 *
 * Generates tokens based on reflection types.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface TypeBasedTokenGeneratorInterface
{
    /**
     * Generates a token for a class type.
     *
     * @param string $className The class name.
     * @param array<string, mixed> $scenarioRefs Map of scenario references to materialise.
     * @param TokenGeneratorInterface $tokenGenerator The token generator for recursive calls.
     * @return object The generated object.
     * @throws ReflectionException When a class cannot be reflected.
     */
    public function generateForClassType(
        string $className,
        array $scenarioRefs,
        TokenGeneratorInterface $tokenGenerator
    ): object;

    /**
     * Generates a token for a named type.
     *
     * @param ReflectionNamedType $type The named type.
     * @param array<string, mixed> $scenarioRefs Map of scenario references to materialise.
     * @param TokenGeneratorInterface $tokenGenerator The token generator for recursive calls.
     * @return mixed The generated token value.
     * @throws ReflectionException When a class cannot be reflected.
     */
    public function generateForNamedType(
        ReflectionNamedType $type,
        array $scenarioRefs,
        TokenGeneratorInterface $tokenGenerator
    ): mixed;

    /**
     * Generates a token for a type name.
     *
     * @param string $typeName The type name.
     * @param array<string, mixed> $scenarioRefs Map of scenario references to materialise.
     * @param TokenGeneratorInterface $tokenGenerator The token generator for recursive calls.
     * @return mixed The generated token value.
     * @throws ReflectionException When a class cannot be reflected.
     */
    public function generateForTypeName(
        string $typeName,
        array $scenarioRefs,
        TokenGeneratorInterface $tokenGenerator
    ): mixed;

    /**
     * Generates a token for a union type.
     *
     * @param ReflectionUnionType $type The union type.
     * @param array<string, mixed> $scenarioRefs Map of scenario references to materialise.
     * @param TokenGeneratorInterface $tokenGenerator The token generator for recursive calls.
     * @return mixed The generated token value.
     * @throws ReflectionException When a class cannot be reflected.
     */
    public function generateForUnionType(
        ReflectionUnionType $type,
        array $scenarioRefs,
        TokenGeneratorInterface $tokenGenerator
    ): mixed;
}
