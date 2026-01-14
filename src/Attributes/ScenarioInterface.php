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

namespace PHPSure\Attributes;

/**
 * Interface ScenarioInterface.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface ScenarioInterface extends CallInterface
{
    public const DEFAULT_INSTANCE = 'default';

    /**
     * Fetches the name of the fixture to use for creating the instance on which an instance method should be called.
     * Only applicable to instance method scenarios.
     */
    public function getInstanceFixtureName(): string;
}
