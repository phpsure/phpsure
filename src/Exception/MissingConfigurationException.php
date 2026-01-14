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
 * Class MissingConfigurationException.
 *
 * Raised when the configuration file phpsure.config.php is missing.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class MissingConfigurationException extends Exception implements ConfigurationExceptionInterface
{
}
