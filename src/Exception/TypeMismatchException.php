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

namespace PHPSure\Exception;

use Exception;
use ReflectionType;

/**
 * Class TypeMismatchException.
 *
 * Raised when a value does not match its declared type.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class TypeMismatchException extends Exception implements TypeExceptionInterface
{
    public function __construct(
        mixed $value,
        ReflectionType $expectedType
    ) {
        $valueType = get_debug_type($value);
        $expectedTypeString = ($expectedType->allowsNull() ? '?' : '') . $expectedType;

        parent::__construct(
            sprintf(
                'Type mismatch: expected %s but got %s',
                $expectedTypeString,
                $valueType
            )
        );
    }
}
