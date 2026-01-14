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

use ReflectionException;

/**
 * Interface FixtureMaterialiserInterface.
 *
 * Materialises objects from fixtures.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface FixtureMaterialiserInterface
{
    /**
     * Materialises an object from a fixture.
     *
     * @param string $className The class name.
     * @param string $fixtureName The fixture name.
     * @return object The materialised object.
     * @throws ReflectionException When the class or method cannot be reflected.
     */
    public function materialiseFixture(string $className, string $fixtureName): object;
}
