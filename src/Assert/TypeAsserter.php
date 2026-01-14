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

namespace PHPSure\Assert;

use InvalidArgumentException;
use PHPSure\Exception\TypeMismatchException;
use PHPSure\Exception\UnsupportedTypeException;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionType;
use ReflectionUnionType;

/**
 * Class TypeAsserter.
 *
 * Asserts that a value matches a given reflection type.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class TypeAsserter implements TypeAsserterInterface
{
    /**
     * @inheritDoc
     */
    public function assertMatches(mixed $value, ReflectionType $type): void
    {
        if ($type instanceof ReflectionNamedType) {
            $this->assertMatchesNamedType($value, $type);
        } elseif ($type instanceof ReflectionUnionType) {
            $this->assertMatchesUnionType($value, $type);
        } elseif ($type instanceof ReflectionIntersectionType) {
            $this->assertMatchesIntersectionType($value, $type);
        } else {
            throw new InvalidArgumentException('Unsupported type "' . $type::class . '"');
        }
    }

    /**
     * @inheritDoc
     */
    public function assertMatchesIntersectionType(mixed $value, ReflectionIntersectionType $type): void
    {
        foreach ($type->getTypes() as $intersectionType) {
            try {
                $this->assertMatches($value, $intersectionType);
            } catch (TypeMismatchException) {
                throw new TypeMismatchException($value, $type);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function assertMatchesNamedType(mixed $value, ReflectionNamedType $type): void
    {
        $typeName = $type->getName();

        // Handle void type - PHP returns null for void functions.
        if ($typeName === 'void') {
            if ($value !== null) {
                throw new TypeMismatchException($value, $type);
            }

            return;
        }

        // Handle nullable types.
        if ($value === null && $type->allowsNull()) {
            return;
        }

        // Handle self, static, and parent - these need to be resolved to actual class names.
        if (in_array($typeName, ['self', 'static', 'parent'], true)) {
            if (!is_object($value)) {
                throw new TypeMismatchException($value, $type);
            }

            // For self/static/parent, just check that it's an object.
            // The actual class validation would require the declaring class context.
            return;
        }

        // Handle built-in types.
        if ($typeName === 'int') {
            if (!is_int($value)) {
                throw new TypeMismatchException($value, $type);
            }

            return;
        }

        if ($typeName === 'float') {
            if (!is_float($value)) {
                throw new TypeMismatchException($value, $type);
            }

            return;
        }

        if ($typeName === 'string') {
            if (!is_string($value)) {
                throw new TypeMismatchException($value, $type);
            }

            return;
        }

        if ($typeName === 'bool') {
            if (!is_bool($value)) {
                throw new TypeMismatchException($value, $type);
            }

            return;
        }

        if ($typeName === 'array') {
            if (!is_array($value)) {
                throw new TypeMismatchException($value, $type);
            }

            return;
        }

        if ($typeName === 'callable') {
            if (!is_callable($value)) {
                throw new TypeMismatchException($value, $type);
            }

            return;
        }

        if ($typeName === 'mixed') {
            // `mixed` accepts anything.
            return;
        }

        // Handle class/interface types.
        if (class_exists($typeName) || interface_exists($typeName)) {
            if (!($value instanceof $typeName)) {
                throw new TypeMismatchException($value, $type);
            }

            return;
        }

        throw new UnsupportedTypeException($value, $type);
    }

    /**
     * @inheritDoc
     */
    public function assertMatchesUnionType(mixed $value, ReflectionUnionType $type): void
    {
        foreach ($type->getTypes() as $unionType) {
            try {
                $this->assertMatches($value, $unionType);

                return; // Matched one of the union types.
            } catch (TypeMismatchException) {
                // Try the next type.
            }
        }

        // Didn't match any type in the union.
        throw new TypeMismatchException($value, $type);
    }
}
