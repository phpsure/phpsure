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
 * Class UnsupportedTypeException.
 *
 * Raised when a type is encountered that is not supported by PHPSure (e.g. from a newer PHP version).
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class UnsupportedTypeException extends Exception implements TypeExceptionInterface
{
    public function __construct(
        mixed $value,
        ReflectionType $expectedType
    ) {
        $valueType = get_debug_type($value);
        $expectedTypeString = ($expectedType->allowsNull() ? '?' : '') . $expectedType;

        parent::__construct(
            sprintf(
                'Unsupported type "%s" encountered when asserting value of type "%s"',
                $expectedTypeString,
                $valueType
            )
        );
    }
}
