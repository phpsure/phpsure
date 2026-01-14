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
 * Interface DiscoveryResultInterface.
 *
 * Represents the result of scanning a directory or file path for callables.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface DiscoveryResultInterface
{
    /**
     * Fetches the discovered class names.
     *
     * @return array<string, string> Map from lowercase class names to original case class names.
     */
    public function getClassNames(): array;

    /**
     * Fetches the discovered function names.
     *
     * @return array<string, string> Map from lowercase function names to original case function names.
     */
    public function getFunctionNames(): array;
}
