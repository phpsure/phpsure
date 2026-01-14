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
use ReflectionMethod;

/**
 * Class Scanner.
 *
 * Discovers functions and class methods in a given directory.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Scanner implements ScannerInterface
{
    public function __construct(
        private readonly FileRequirerInterface $fileRequirer = new FileRequirer(),
        private readonly FunctionDiscovererInterface $functionDiscoverer = new FunctionDiscoverer(),
        private readonly ClassDiscovererInterface $classDiscoverer = new ClassDiscoverer()
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getInstanceMethods(string $className): array
    {
        $class = new ReflectionClass($className);
        $methods = [];

        foreach ($class->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            // Skip constructors, static methods, and abstract methods
            if ($method->isConstructor() ||
                $method->isStatic() ||
                $method->isAbstract()
            ) {
                continue;
            }

            $methods[$method->getName()] = $method;
        }

        return $methods;
    }

    /**
     * @inheritDoc
     */
    public function getStaticMethods(string $className): array
    {
        $class = new ReflectionClass($className);
        $methods = [];

        foreach ($class->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            // Skip constructors, instance methods, and abstract methods
            if ($method->isConstructor() ||
                !$method->isStatic() ||
                $method->isAbstract()
            ) {
                continue;
            }

            $methods[$method->getName()] = $method;
        }

        return $methods;
    }

    /**
     * @inheritDoc
     */
    public function scan(string $path): DiscoveryResultInterface
    {
        $requiredFiles = $this->fileRequirer->requireFiles($path);

        $discoveredFunctions = $this->functionDiscoverer->discoverFunctions($requiredFiles);
        $discoveredClasses = $this->classDiscoverer->discoverClasses($requiredFiles);

        return new DiscoveryResult(
            $discoveredFunctions,
            $discoveredClasses
        );
    }
}
