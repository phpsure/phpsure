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

namespace PHPSure\Config;

use PHPSure\Exception\InvalidConfigurationException;
use PHPSure\Exception\MissingConfigurationException;

/**
 * Interface ConfigResolverInterface.
 *
 * Resolves the config from phpsure.config.php.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface ConfigResolverInterface
{
    /**
     * Resolves the PHPSure config.
     *
     * @throws MissingConfigurationException When the configuration file phpsure.config.php is missing.
     * @throws InvalidConfigurationException When the configuration file phpsure.config.php is invalid.
     */
    public function resolveConfig(): ConfigInterface;
}
