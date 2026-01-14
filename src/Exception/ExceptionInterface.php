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

use Throwable;

/**
 * Interface ExceptionInterface.
 *
 * Implemented by all exceptions raised by PHPSure.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface ExceptionInterface extends Throwable
{
}
