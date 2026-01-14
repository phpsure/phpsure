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

/**
 * Class InvalidPathException.
 *
 * Raised when an invalid path is given.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class InvalidPathException extends Exception implements ExceptionInterface
{
}
