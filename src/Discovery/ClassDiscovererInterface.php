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
 * Interface ClassDiscovererInterface.
 *
 * Discovers classes that have been loaded from required files.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface ClassDiscovererInterface
{
    /**
     * Discovers classes that have been loaded from required files.
     *
     * @param array<string, true> $requiredFiles Map of file paths for fast hash-based lookup.
     * @return array<string, string> Map of lowercase class name to original case class name.
     */
    public function discoverClasses(array $requiredFiles): array;
}
