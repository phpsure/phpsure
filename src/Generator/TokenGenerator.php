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

use ReflectionFunctionAbstract;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionType;
use ReflectionUnionType;
use RuntimeException;

/**
 * Class TokenGenerator.
 *
 * Generates deterministic token/sample arguments for parameters.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class TokenGenerator implements TokenGeneratorInterface
{
    public function __construct(
        private readonly TypeBasedTokenGeneratorInterface $typeBasedTokenGenerator
    ) {
    }

    /**
     * @inheritDoc
     */
    public function generateForParameters(ReflectionFunctionAbstract $function, array $scenarioRefs = []): array
    {
        $args = [];

        foreach ($function->getParameters() as $parameter) {
            if ($parameter->isOptional()) {
                // Skip optional parameters.
                break;
            }

            $args[] = $this->generateForType($parameter->getType(), $scenarioRefs);
        }

        return $args;
    }

    /**
     * @inheritDoc
     */
    public function generateForType(?ReflectionType $type, array $scenarioRefs = []): mixed
    {
        if ($type === null) {
            return null;
        }

        if ($type instanceof ReflectionUnionType) {
            return $this->typeBasedTokenGenerator->generateForUnionType($type, $scenarioRefs, $this);
        }

        if ($type instanceof ReflectionIntersectionType) {
            // For POC, just pick the first type from the intersection.
            $types = $type->getTypes();
            $firstType = $types[0];

            if (!$firstType instanceof ReflectionNamedType) {
                throw new RuntimeException('Intersection type must contain named types');
            }

            return $this->typeBasedTokenGenerator->generateForNamedType($firstType, $scenarioRefs, $this);
        }

        if ($type instanceof ReflectionNamedType) {
            return $this->typeBasedTokenGenerator->generateForNamedType($type, $scenarioRefs, $this);
        }

        return null;
    }
}
