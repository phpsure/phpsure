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
use RuntimeException;

/**
 * Class FixtureMaterialiser.
 *
 * Materialises objects from fixtures.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class FixtureMaterialiser implements FixtureMaterialiserInterface
{
    /**
     * @var array<string, array<string, array{fixture: FixtureInterface, factory: string}>> Cache of fixture scenarios by class.
     */
    private array $fixtureCache = [];

    public function __construct(
        private readonly FixtureResolverInterface $fixtureResolver,
        private readonly ArgumentResolverInterface $argumentResolver
    ) {
    }

    /**
     * @inheritDoc
     */
    public function materialiseFixture(string $className, string $fixtureName): object
    {
        $fixtures = $this->fixtureCache[$className] ??
            ($this->fixtureCache[$className] = $this->fixtureResolver->fetchFixtures($className));

        if (!isset($fixtures[$fixtureName])) {
            throw new RuntimeException(
                sprintf(
                    'Fixture "%s" not found for class "%s"',
                    $fixtureName,
                    $className
                )
            );
        }

        ['fixture' => $fixture, 'factory' => $factoryMethod] = $fixtures[$fixtureName];
        $args = $this->argumentResolver->resolveScenarioArguments($fixture->getArguments(), $this);

        return $factoryMethod === '__construct' ?
            // Natural constructor should be used - `__construct()` if defined, otherwise none.
            new $className(...$args) :
            // A static factory method should be used.
            $className::{$factoryMethod}(...$args);
    }
}
