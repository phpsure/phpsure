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
 * Class ConfigResolver.
 *
 * Resolves the config from phpsure.config.php.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ConfigResolver implements ConfigResolverInterface
{
    public function __construct(
        private readonly string $projectRoot,
        private readonly string $configFileName = 'phpsure.config.php'
    ) {
    }

    /**
     * @inheritDoc
     */
    public function resolveConfig(): ConfigInterface
    {
        $configPath = $this->projectRoot . DIRECTORY_SEPARATOR . $this->configFileName;

        if (!is_file($configPath)) {
            throw new MissingConfigurationException(
                sprintf(
                    'PHPSure config file %s is required but was not found',
                    $configPath
                )
            );
        }

        $config = require $configPath;

        if (!($config instanceof ConfigInterface)) {
            throw new InvalidConfigurationException(
                sprintf(
                    'Return value of module %s is expected to be an instance of %s but was not',
                    $configPath,
                    ConfigInterface::class
                )
            );
        }

        return $config;
    }
}
