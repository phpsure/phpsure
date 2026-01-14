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

use ReflectionClass;
use ReflectionException;

/**
 * Class ClassDiscoverer.
 *
 * Discovers classes that have been loaded from required files.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ClassDiscoverer implements ClassDiscovererInterface
{
    /**
     * @inheritDoc
     */
    public function discoverClasses(array $requiredFiles): array
    {
        $discoveredClasses = [];
        $allClasses = get_declared_classes();

        foreach ($allClasses as $className) {
            try {
                $class = new ReflectionClass($className);
                $fileName = $class->getFileName();

                // Only include classes from files we required for testing.
                if ($fileName !== false && isset($requiredFiles[$fileName])) {
                    // Store lowercase key for case-insensitive lookup, but keep original case as value.
                    $discoveredClasses[strtolower($className)] = $className;
                }
            } catch (ReflectionException) {
                // Skip classes that cannot be reflected.
            }
        }

        return $discoveredClasses;
    }
}
