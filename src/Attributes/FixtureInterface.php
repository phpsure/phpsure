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
 * Interface FixtureInterface.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface FixtureInterface extends CallInterface
{
    public const DEFAULT_NAME = 'default';

    /**
     * Fetches the unique name of the fixture.
     */
    public function getName(): string;
}
