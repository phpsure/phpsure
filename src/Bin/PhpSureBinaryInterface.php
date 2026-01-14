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

namespace PHPSure\Bin;

/**
 * Interface PhpSureBinaryInterface.
 *
 * Defines the contract for the `phpsure` binary entrypoint.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface PhpSureBinaryInterface
{
    /**
     * Runs the binary with the given CLI arguments.
     *
     * @param string[] $argv CLI arguments.
     * @return int Exit code.
     */
    public function run(array $argv): int;
}
