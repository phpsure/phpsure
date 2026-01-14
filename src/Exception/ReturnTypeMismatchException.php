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
use Throwable;

/**
 * Class ReturnTypeMismatchException.
 *
 * Raised when a return value does not match its declared return type.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ReturnTypeMismatchException extends Exception implements TypeExceptionInterface
{
    public function __construct(
        string $callableName,
        ?Throwable $previous = null
    ) {
        parent::__construct(
            sprintf(
                'Return type mismatch for %s: %s',
                $callableName,
                $previous?->getMessage() ?? 'type mismatch'
            ),
            0,
            $previous
        );
    }
}
