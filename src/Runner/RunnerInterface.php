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

namespace PHPSure\Runner;

use PHPSure\Exception\InvalidPathException;
use PHPSure\Runner\Result\TestResult;

/**
 * Interface RunnerInterface.
 *
 * Runs tests on discovered callables.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface RunnerInterface
{
    /**
     * Runs tests on all callables in the given directory or file.
     *
     * @param string $path The directory or file to scan and test.
     * @return TestResult The test result.
     * @throws InvalidPathException When the given path is not a directory or a PHP file.
     */
    public function run(string $path): TestResult;
}
