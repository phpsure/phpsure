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
use ReflectionFunctionAbstract;
use ReflectionType;

/**
 * Interface TokenGeneratorInterface.
 *
 * Generates deterministic token/sample arguments for parameters.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface TokenGeneratorInterface
{
    /**
     * Generates arguments for a callable's parameters.
     *
     * @param ReflectionFunctionAbstract $function The function or method to generate args for.
     * @param array<string, mixed> $scenarioRefs Map of scenario references to materialise.
     * @return array<int, mixed> Generated arguments.
     * @throws ReflectionException When a class cannot be reflected.
     */
    public function generateForParameters(ReflectionFunctionAbstract $function, array $scenarioRefs = []): array;

    /**
     * Generates a token value for the given reflection type.
     *
     * @param ReflectionType|null $type The type to generate a token for.
     * @param array<string, mixed> $scenarioRefs Map of scenario references to materialise.
     * @return mixed The generated token value.
     * @throws ReflectionException When a class cannot be reflected.
     */
    public function generateForType(?ReflectionType $type, array $scenarioRefs = []): mixed;
}
