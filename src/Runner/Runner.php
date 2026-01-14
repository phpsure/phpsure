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

use PHPSure\Discovery\Scanner;
use PHPSure\Runner\Result\FailResult;
use PHPSure\Runner\Result\PassResult;
use PHPSure\Runner\Result\SkipResult;
use PHPSure\Runner\Result\TestResult;
use PHPSure\Runner\Result\WarningResult;

/**
 * Class Runner.
 *
 * Runs tests on discovered callables.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Runner implements RunnerInterface
{
    /** @var array<PassResult> */
    private array $passes = [];
    /** @var array<FailResult> */
    private array $failures = [];
    /** @var array<SkipResult> */
    private array $skips = [];
    /** @var array<WarningResult> */
    private array $warnings = [];

    public function __construct(
        private readonly Scanner $scanner,
        private readonly FunctionTesterInterface $functionTester,
        private readonly ClassTesterInterface $classTester
    ) {
    }

    /**
     * @inheritDoc
     */
    public function run(string $path): TestResult
    {
        $scanResult = $this->scanner->scan($path);

        $this->functionTester->testFunctions($scanResult, $this->passes, $this->failures, $this->skips, $this->warnings);
        $this->classTester->testClasses($scanResult, $this->passes, $this->failures, $this->skips, $this->warnings);

        return new TestResult(
            $this->passes,
            $this->failures,
            $this->skips,
            $this->warnings
        );
    }
}
