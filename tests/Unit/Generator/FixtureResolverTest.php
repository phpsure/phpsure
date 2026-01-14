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

namespace PHPSure\Tests\Unit\Generator;

use PHPSure\Generator\FixtureResolver;
use PHPSure\Generator\TokenGeneratorInterface;
use PHPSure\Tests\AbstractTestCase;
use ReflectionClass;

/**
 * Class FixtureResolverTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class FixtureResolverTest extends AbstractTestCase
{
    private FixtureResolver $fixtureResolver;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixtureResolver = new FixtureResolver();
    }

    public function testFindDefaultFixtureReturnsNullWhenNoFixturesExist(): void
    {
        $class = new ReflectionClass(\stdClass::class);

        $result = $this->fixtureResolver->findDefaultFixture($class);

        static::assertNull($result);
    }

    public function testFetchFixturesReturnsEmptyArrayForClassWithoutFixtures(): void
    {
        $result = $this->fixtureResolver->fetchFixtures(\stdClass::class);

        static::assertSame([], $result);
    }
}
