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

/**
 * Class ArgumentResolver.
 *
 * Resolves scenario arguments, materialising nested fixture references.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ArgumentResolver implements ArgumentResolverInterface
{
    /**
     * @inheritDoc
     */
    public function resolveScenarioArguments(array $args, FixtureMaterialiserInterface $fixtureMaterialiser): array
    {
        $resolved = [];

        foreach ($args as $arg) {
            if (is_array($arg) && isset($arg['fixture'])) {
                [$className, $fixtureName] = $arg['fixture'];
                $resolved[] = $fixtureMaterialiser->materialiseFixture($className, $fixtureName);
            } else {
                $resolved[] = $arg;
            }
        }

        return $resolved;
    }
}
