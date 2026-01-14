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

use PHPSure\Implementation\ImplementationInterface;

/**
 * Interface ConfigInterface.
 *
 * Configuration for PHPSure, allowing implementors to override the implementation.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface ConfigInterface
{
    /**
     * Fetches the Implementation instance.
     */
    public function getImplementation(): ImplementationInterface;

    /**
     * Sets a custom Implementation instance.
     */
    public function setImplementation(ImplementationInterface $implementation): self;
}
