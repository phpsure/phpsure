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

namespace PHPSure\Config;

/**
 * Interface ProjectRootResolverInterface.
 *
 * Resolves the project root directory.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface ProjectRootResolverInterface
{
    /**
     * Resolves the project root directory.
     *
     * @return string The project root directory path.
     */
    public function resolveProjectRoot(): string;
}
