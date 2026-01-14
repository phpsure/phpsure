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

use PHPSure\Runner\Result\TestResult;

/**
 * Interface ScanCommandInterface.
 *
 * Defines the contract for the `scan` command.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface ScanCommandInterface
{
    /**
     * Runs the `scan` command with the given path and options.
     *
     * @param string $path The directory or file to scan.
     * @param array<string, mixed> $options CLI options.
     */
    public function run(string $path, array $options): ?TestResult;
}
