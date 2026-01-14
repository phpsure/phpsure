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

namespace PHPSure\Generator;

use PHPSure\Attributes\FixtureInterface;
use ReflectionClass;
use ReflectionException;

/**
 * Interface FixtureResolverInterface.
 *
 * Resolves and fetches fixtures and scenarios from classes and methods.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface FixtureResolverInterface
{
    /**
     * Fetches all fixtures for a class method.
     *
     * @param string $className The class name.
     * @return array<string, array{fixture: FixtureInterface, factory: string}> Map of fixture name to data.
     * @throws ReflectionException When the class or method cannot be reflected.
     */
    public function fetchFixtures(string $className): array;

    /**
     * Finds a default fixture for a class.
     *
     * If no fixture is explicitly named 'default', returns the first fixture found.
     *
     * @param ReflectionClass<object> $class The class to search.
     * @return array{name: string, factory: string}|null The fixture info, or null if not found.
     */
    public function findDefaultFixture(ReflectionClass $class): ?array;
}
