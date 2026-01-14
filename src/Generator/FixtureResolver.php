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
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;

/**
 * Class FixtureResolver.
 *
 * Resolves and fetches fixture scenarios from classes and methods.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class FixtureResolver implements FixtureResolverInterface
{
    /**
     * @inheritDoc
     */
    public function fetchFixtures(string $className): array
    {
        $reflection = new ReflectionClass($className);
        $fixtures = [];

        $constructor = $reflection->getConstructor();

        // TODO: Report somehow if constructor is private/protected but has fixtures defined.
        if ($constructor !== null && $constructor->isPublic()) {
            $attributes = $constructor->getAttributes(FixtureInterface::class, ReflectionAttribute::IS_INSTANCEOF);

            foreach ($attributes as $attribute) {
                $fixture = $attribute->newInstance();
                $fixtures[$fixture->getName()] = ['fixture' => $fixture, 'factory' => '__construct'];
            }
        }

        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_STATIC) as $method) {
            if ($method->isConstructor()) {
                continue;
            }

            $attributes = $method->getAttributes(FixtureInterface::class, ReflectionAttribute::IS_INSTANCEOF);

            foreach ($attributes as $attribute) {
                $fixture = $attribute->newInstance();
                $fixtures[$fixture->getName()] = ['fixture' => $fixture, 'factory' => $method->getName()];
            }
        }

        return $fixtures;
    }

    /**
     * @inheritDoc
     */
    public function findDefaultFixture(ReflectionClass $class): ?array
    {
        // First, check for a "default" fixture on the constructor.
        $constructor = $class->getConstructor();

        if ($constructor !== null && $constructor->isPublic()) {
            $attributes = $constructor->getAttributes(FixtureInterface::class, ReflectionAttribute::IS_INSTANCEOF);

            foreach ($attributes as $attribute) {
                $fixture = $attribute->newInstance();

                if ($fixture->getName() === FixtureInterface::DEFAULT_NAME) {
                    return [
                        'name' => FixtureInterface::DEFAULT_NAME,
                        'factory' => '__construct',
                    ];
                }
            }
        }

        $publicStaticMethods = $class->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_STATIC);

        // Second, check for a "default" fixture on a static factory method.
        foreach ($publicStaticMethods as $method) {
            $attributes = $method->getAttributes(FixtureInterface::class, ReflectionAttribute::IS_INSTANCEOF);

            foreach ($attributes as $attribute) {
                $fixture = $attribute->newInstance();

                if ($fixture->getName() === FixtureInterface::DEFAULT_NAME) {
                    return [
                        'name' => FixtureInterface::DEFAULT_NAME,
                        'factory' => $method->getName(),
                    ];
                }
            }
        }

        // No explicit "default" fixture found.
        // Look for the first fixture on any static factory method.
        foreach ($publicStaticMethods as $method) {
            $attributes = $method->getAttributes(FixtureInterface::class, ReflectionAttribute::IS_INSTANCEOF);

            foreach ($attributes as $attribute) {
                $fixture = $attribute->newInstance();

                return [
                    'name' => $fixture->getName(),
                    'factory' => $method->getName(),
                ];
            }
        }

        return null;
    }
}
