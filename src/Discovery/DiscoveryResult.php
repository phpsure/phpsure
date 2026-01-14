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

namespace PHPSure\Discovery;

/**
 * Class DiscoveryResult.
 *
 * Represents the result of scanning a directory or file path for callables.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class DiscoveryResult implements DiscoveryResultInterface
{
    /**
     * @param array<string, string> $functions Map of lowercase function name to original case function name.
     * @param array<string, string> $classes Map of lowercase class name to original case class name.
     */
    public function __construct(
        private readonly array $functions,
        private readonly array $classes
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getClassNames(): array
    {
        return $this->classes;
    }

    /**
     * @inheritDoc
     */
    public function getFunctionNames(): array
    {
        return $this->functions;
    }
}
