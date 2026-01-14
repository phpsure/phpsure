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

use Composer\Autoload\ClassLoader;
use ReflectionClass;

/**
 * Class ProjectRootResolver.
 *
 * Resolves the project root directory.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ProjectRootResolver implements ProjectRootResolverInterface
{
    /**
     * @param ReflectionClass<ClassLoader> $classLoaderReflectionClass
     */
    public function __construct(
        private readonly ReflectionClass $classLoaderReflectionClass
    ) {
    }

    /**
     * @inheritDoc
     */
    public function resolveProjectRoot(): string
    {
        return dirname($this->classLoaderReflectionClass->getFileName(), 3);
    }
}
