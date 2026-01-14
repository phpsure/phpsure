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

use PHPSure\Exception\TypeMismatchException;
use PHPSure\Exception\UnsupportedTypeException;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionType;
use ReflectionUnionType;

/**
 * Interface TypeAsserterInterface.
 *
 * Asserts that a value matches a given reflection type.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface TypeAsserterInterface
{
    /**
     * Asserts that the given value matches the expected type.
     *
     * @param mixed $value The value to check.
     * @param ReflectionType $type The expected type.
     * @throws TypeMismatchException When the value does not match the type.
     * @throws UnsupportedTypeException When an unsupported type is encountered.
     */
    public function assertMatches(mixed $value, ReflectionType $type): void;

    /**
     * Asserts that the value matches an intersection type.
     *
     * @param mixed $value The value to check.
     * @param ReflectionIntersectionType $type The expected type.
     * @throws TypeMismatchException When the value does not match all types in the intersection.
     * @throws UnsupportedTypeException When an unsupported type is encountered.
     */
    public function assertMatchesIntersectionType(mixed $value, ReflectionIntersectionType $type): void;

    /**
     * Asserts that the value matches a named type.
     *
     * @param mixed $value The value to check.
     * @param ReflectionNamedType $type The expected type.
     * @throws TypeMismatchException When the value does not match the type.
     * @throws UnsupportedTypeException When an unsupported type is encountered.
     */
    public function assertMatchesNamedType(mixed $value, ReflectionNamedType $type): void;

    /**
     * Asserts that the value matches a union type.
     *
     * @param mixed $value The value to check.
     * @param ReflectionUnionType $type The expected type.
     * @throws TypeMismatchException When the value does not match any type in the union.
     * @throws UnsupportedTypeException When an unsupported type is encountered.
     */
    public function assertMatchesUnionType(mixed $value, ReflectionUnionType $type): void;
}
