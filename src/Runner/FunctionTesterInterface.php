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

use PHPSure\Discovery\DiscoveryResultInterface;
use PHPSure\Runner\Result\FailResult;
use PHPSure\Runner\Result\PassResult;
use PHPSure\Runner\Result\SkipResult;
use PHPSure\Runner\Result\WarningResult;

/**
 * Interface FunctionTesterInterface.
 *
 * Tests functions.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface FunctionTesterInterface
{
    /**
     * Tests all discovered functions.
     *
     * @param DiscoveryResultInterface $discoveryResult The result of scanning for functions.
     * @param array<PassResult> &$passes Output parameter for pass results.
     * @param array<FailResult> &$failures Output parameter for fail results.
     * @param array<SkipResult> &$skips Output parameter for skip results.
     * @param array<WarningResult> &$warnings Output parameter for warning results.
     */
    public function testFunctions(
        DiscoveryResultInterface $discoveryResult,
        array &$passes,
        array &$failures,
        array &$skips,
        array &$warnings
    ): void;
}
