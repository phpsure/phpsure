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

namespace PHPSure\Tests\Unit\Config;

use Composer\Autoload\ClassLoader;
use PHPSure\Config\ProjectRootResolver;
use PHPSure\Tests\AbstractTestCase;
use ReflectionClass;

/**
 * Class ProjectRootResolverTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ProjectRootResolverTest extends AbstractTestCase
{
    private ProjectRootResolver $projectRootResolver;

    protected function setUp(): void
    {
        parent::setUp();

        $classLoaderReflection = new ReflectionClass(ClassLoader::class);
        $this->projectRootResolver = new ProjectRootResolver($classLoaderReflection);
    }

    public function testResolveProjectRootReturnsCorrectPath(): void
    {
        $projectRoot = $this->projectRootResolver->resolveProjectRoot();

        // The project root should be 3 directories up from vendor/composer/ClassLoader.php.
        static::assertStringEndsWith('phpsure', $projectRoot);
        static::assertDirectoryExists($projectRoot);
    }
}
