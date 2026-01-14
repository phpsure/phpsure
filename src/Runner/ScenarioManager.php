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
use PHPSure\Generator\TokenGenerator;
use ReflectionAttribute;
use ReflectionMethod;

/**
 * Class ScenarioManager.
 *
 * Manages scenarios and fixtures for methods and constructors.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ScenarioManager implements ScenarioManagerInterface
{

    /**
     * @inheritDoc
     */
    public function findFixtureByName(array $fixtures, string $name): ?Fixture
    {
        foreach ($fixtures as $fixture) {
            if ($fixture->getName() === $name) {
                return $fixture;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getFixtures(ReflectionMethod $method): array
    {
        $fixtures = [];

        $attributes = $method->getAttributes(Fixture::class, ReflectionAttribute::IS_INSTANCEOF);

        foreach ($attributes as $attribute) {
            $fixtures[] = $attribute->newInstance();
        }

        return $fixtures;
    }

    /**
     * @inheritDoc
     */
    public function getScenarios(ReflectionMethod $method): array
    {
        $scenarios = [];

        // Get both Scenario and Fixture attributes (both implement CallInterface).
        $attributes = $method->getAttributes(CallInterface::class, ReflectionAttribute::IS_INSTANCEOF);

        foreach ($attributes as $attribute) {
            $scenarios[] = $attribute->newInstance();
        }

        return $scenarios;
    }
}
