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
 * Interface ParameterResolverInterface.
 *
 * Resolves function or method parameters.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface ParameterResolverInterface
{
    /**
     * Checks whether a function has no required parameters.
     *
     * @param ReflectionFunctionAbstract $function The function to check.
     * @return bool True if no required parameters, false otherwise.
     */
    public function hasNoRequiredParams(ReflectionFunctionAbstract $function): bool;
}
