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

namespace PHPSure\Implementation;

use PHPSure\Bin\PhpSureBinaryInterface;
use PHPSure\Io\OutputInterface;
use PHPSure\Runner\RunnerInterface;

/**
 * Interface ImplementationInterface.
 *
 * Defines the contract for PHPSure implementations.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface ImplementationInterface
{
    /**
     * Gets the PhpSure binary instance.
     */
    public function getPhpSureBinary(): PhpSureBinaryInterface;

    /**
     * Gets the Runner instance.
     */
    public function getRunner(): RunnerInterface;

    /**
     * Gets the stderr output instance.
     */
    public function getStderr(): OutputInterface;

    /**
     * Gets the stdout output instance.
     */
    public function getStdout(): OutputInterface;
}
