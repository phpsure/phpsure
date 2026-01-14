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

namespace PHPSure\Runner\Result;

/**
 * Class FailResult.
 *
 * Represents a single failed test.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class FailResult
{
    /**
     * @param string $identifier The full identifier of the test (e.g., "ClassName::methodName" or "ClassName::methodName [scenarioName]").
     * @param string $message The error message describing why the test failed.
     */
    public function __construct(
        public readonly string $identifier,
        public readonly string $message
    ) {
    }
}
