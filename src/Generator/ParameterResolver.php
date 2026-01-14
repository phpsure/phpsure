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

use ReflectionFunctionAbstract;

/**
 * Class ParameterResolver.
 *
 * Resolves function or method parameters.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ParameterResolver implements ParameterResolverInterface
{
    /**
     * @inheritDoc
     */
    public function hasNoRequiredParams(ReflectionFunctionAbstract $function): bool
    {
        foreach ($function->getParameters() as $parameter) {
            if (!$parameter->isOptional()) {
                return false;
            }
        }

        return true;
    }
}
