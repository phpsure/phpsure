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

use PHPSure\Implementation\Implementation;
use PHPSure\Implementation\ImplementationInterface;

/**
 * Class Config.
 *
 * Configuration for PHPSure, allowing implementors to override the implementation.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Config implements ConfigInterface
{
    private ?ImplementationInterface $implementation = null;

    /**
     * @inheritDoc
     */
    public function getImplementation(): ImplementationInterface
    {
        if ($this->implementation === null) {
            $this->implementation = new Implementation();
        }

        return $this->implementation;
    }

    /**
     * @inheritDoc
     */
    public function setImplementation(ImplementationInterface $implementation): self
    {
        $this->implementation = $implementation;

        return $this; // Fluent interface.
    }
}
