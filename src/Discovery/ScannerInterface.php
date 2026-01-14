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

use PHPSure\Exception\InvalidPathException;
use ReflectionException;
use ReflectionMethod;

/**
 * Interface ScannerInterface.
 *
 * Discovers functions and class methods in a given directory.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface ScannerInterface
{
    /**
     * Gets the public instance methods for a class.
     *
     * @param string $className The class name.
     * @return array<string, ReflectionMethod> Map of method name to ReflectionMethod.
     * @throws ReflectionException When the class cannot be reflected.
     */
    public function getInstanceMethods(string $className): array;

    /**
     * Gets the public static methods for a class.
     *
     * @param string $className The class name.
     * @return array<string, ReflectionMethod> Map of method name to ReflectionMethod.
     * @throws ReflectionException When the class cannot be reflected.
     */
    public function getStaticMethods(string $className): array;

    /**
     * Discovers all callables in the given directory or file.
     *
     * @param string $path The directory or file to scan.
     * @return DiscoveryResultInterface The scan result containing discovered callables.
     * @throws InvalidPathException When the given path is not a directory or a PHP file.
     */
    public function scan(string $path): DiscoveryResultInterface;
}
