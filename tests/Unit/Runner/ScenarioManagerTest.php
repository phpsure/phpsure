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

namespace PHPSure\Tests\Unit\Runner;

use Mockery\MockInterface;
use PHPSure\Attributes\Fixture;
use PHPSure\Attributes\Scenario;
use PHPSure\Generator\TokenGenerator;
use PHPSure\Runner\ScenarioManager;
use PHPSure\Tests\AbstractTestCase;
use ReflectionMethod;
use stdClass;

/**
 * Class ScenarioManagerTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ScenarioManagerTest extends AbstractTestCase
{
    private ScenarioManager $scenarioManager;

    public function setUp(): void
    {
        $this->scenarioManager = new ScenarioManager();
    }

    public function testGetScenariosReturnsEmptyArrayWhenNoScenariosExist(): void
    {
        $method = new ReflectionMethod(ScenarioManagerTestFixture::class, 'methodWithoutScenarios');

        $scenarios = $this->scenarioManager->getScenarios($method);

        $this->assertSame([], $scenarios);
    }

    public function testGetScenariosReturnsScenarioInstancesWhenScenariosExist(): void
    {
        $method = new ReflectionMethod(ScenarioManagerTestFixture::class, 'methodWithScenarios');

        $scenarios = $this->scenarioManager->getScenarios($method);

        $this->assertCount(2, $scenarios);
        $this->assertInstanceOf(Scenario::class, $scenarios[0]);
        $this->assertInstanceOf(Scenario::class, $scenarios[1]);
        $this->assertSame('scenario1', $scenarios[0]->getDescription());
        $this->assertSame('scenario2', $scenarios[1]->getDescription());
    }

    public function testFindFixtureByNameReturnsNullWhenFixtureNotFound(): void
    {
        $fixtures = [
            new Fixture(name: 'fixture1', args: [1, 2]),
            new Fixture(name: 'fixture2', args: [3, 4]),
        ];

        $result = $this->scenarioManager->findFixtureByName($fixtures, 'nonexistent');

        $this->assertNull($result);
    }

    public function testFindFixtureByNameReturnsFixtureWhenFound(): void
    {
        $fixture1 = new Fixture(name: 'fixture1', args: [1, 2]);
        $fixture2 = new Fixture(name: 'fixture2', args: [3, 4]);
        $fixtures = [$fixture1, $fixture2];

        $result = $this->scenarioManager->findFixtureByName($fixtures, 'fixture2');

        $this->assertSame($fixture2, $result);
    }

    public function testFindFixtureByNameReturnsFirstMatchingFixture(): void
    {
        $fixture1 = new Fixture(name: 'duplicate', args: [1, 2]);
        $fixture2 = new Fixture(name: 'duplicate', args: [3, 4]);
        $fixtures = [$fixture1, $fixture2];

        $result = $this->scenarioManager->findFixtureByName($fixtures, 'duplicate');

        $this->assertSame($fixture1, $result);
    }

    public function testGetFixturesReturnsEmptyArrayWhenNoFixturesExist(): void
    {
        $method = new ReflectionMethod(ScenarioManagerTestFixture::class, 'methodWithoutScenarios');

        $fixtures = $this->scenarioManager->getFixtures($method);

        $this->assertSame([], $fixtures);
    }

    public function testGetFixturesReturnsFixtureInstancesWhenFixturesExist(): void
    {
        $method = new ReflectionMethod(ScenarioManagerTestFixture::class, 'methodWithFixtures');

        $fixtures = $this->scenarioManager->getFixtures($method);

        $this->assertCount(2, $fixtures);
        $this->assertInstanceOf(Fixture::class, $fixtures[0]);
        $this->assertInstanceOf(Fixture::class, $fixtures[1]);
        $this->assertSame('fixture1', $fixtures[0]->getName());
        $this->assertSame('fixture2', $fixtures[1]->getName());
    }
}

/**
 * Fixture class for ScenarioManagerTest.
 */
class ScenarioManagerTestFixture
{
    public function methodWithoutScenarios(): void
    {
    }

    #[Scenario(description: 'scenario1', args: [1, 2])]
    #[Scenario(description: 'scenario2', args: [3, 4])]
    public function methodWithScenarios(): void
    {
    }

    #[Fixture(name: 'fixture1', args: [1, 2])]
    #[Fixture(name: 'fixture2', args: [3, 4])]
    public function methodWithFixtures(): void
    {
    }
}
