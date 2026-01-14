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

namespace PHPSure\Discovery;

/**
 * Interface FunctionDiscovererInterface.
 *
 * Discovers user functions that have been loaded from required files.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface FunctionDiscovererInterface
{
    /**
     * Discovers user functions that have been loaded from the required files.
     *
     * @param array<string, true> $requiredFiles Map of file paths to true.
     * @return array<string, string> Map of lowercase function name to original case function name.
     */
    public function discoverFunctions(array $requiredFiles): array;
}
