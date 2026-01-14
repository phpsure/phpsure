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

namespace PHPSure\Runner;

use PHPSure\Attributes\CallInterface;
use PHPSure\Attributes\Fixture;
use PHPSure\Attributes\Scenario;
use ReflectionMethod;

/**
 * Interface ScenarioManagerInterface.
 *
 * Manages scenarios and fixtures for methods and constructors.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface ScenarioManagerInterface
{
    /**
     * Finds a fixture by name in an array of fixtures.
     *
     * @param array<int, Fixture> $fixtures The fixtures to search.
     * @param string $name The name to search for.
     * @return Fixture|null The fixture if found, null otherwise.
     */
    public function findFixtureByName(array $fixtures, string $name): ?Fixture;

    /**
     * Gets all fixtures for a method (constructor or static factory method).
     *
     * @param ReflectionMethod $method The method.
     * @return array<int, Fixture> Array of Fixture instances.
     */
    public function getFixtures(ReflectionMethod $method): array;

    /**
     * Gets all scenarios for a method.
     *
     * This includes both Scenario and Fixture attributes (both implement CallInterface).
     *
     * @param ReflectionMethod $method The method.
     * @return array<int, CallInterface> Array of CallInterface instances (Scenario or Fixture).
     */
    public function getScenarios(ReflectionMethod $method): array;
}
