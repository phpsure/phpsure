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

use ReflectionException;
use ReflectionFunction;

/**
 * Class FunctionDiscoverer.
 *
 * Discovers user functions that have been loaded from required files.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class FunctionDiscoverer implements FunctionDiscovererInterface
{
    /**
     * @inheritDoc
     */
    public function discoverFunctions(array $requiredFiles): array
    {
        $discoveredFunctions = [];
        $allUserFunctions = get_defined_functions()['user'];

        foreach ($allUserFunctions as $functionName) {
            try {
                $function = new ReflectionFunction($functionName);
                $fileName = $function->getFileName();

                // Only include functions from files we required.
                if ($fileName !== false && isset($requiredFiles[$fileName])) {
                    // get_defined_functions() returns lowercase names, so use ReflectionFunction::getName() for original case.
                    $originalCaseName = $function->getName();
                    // Store lowercase key for case-insensitive lookup, but keep original case as value.
                    $discoveredFunctions[strtolower($originalCaseName)] = $originalCaseName;
                }
            } catch (ReflectionException) {
                // Skip functions that cannot be reflected.
            }
        }

        return $discoveredFunctions;
    }
}
