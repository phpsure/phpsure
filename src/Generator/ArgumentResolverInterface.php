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
 * Interface ArgumentResolverInterface.
 *
 * Resolves scenario arguments, materialising nested fixture references.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface ArgumentResolverInterface
{
    /**
     * Resolves scenario arguments, materialising nested fixture references.
     *
     * @param array<mixed> $args The scenario arguments.
     * @param FixtureMaterialiserInterface $fixtureMaterialiser
     * @return array<mixed> The resolved arguments.
     * @throws ReflectionException When a class cannot be reflected.
     */
    public function resolveScenarioArguments(array $args, FixtureMaterialiserInterface $fixtureMaterialiser): array;
}
