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
 * Interface CallInterface.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface CallInterface
{
    /**
     * Fetches the expected arguments for the scenario.
     *
     * @return array<mixed>
     */
    public function getArguments(): array;

    /**
     * Fetches the description of the scenario, if any.
     */
    public function getDescription(): ?string;

    /**
     * Fetches the expectation set for the return value of the scenario.
     */
    public function getExpectation(): mixed;
}
