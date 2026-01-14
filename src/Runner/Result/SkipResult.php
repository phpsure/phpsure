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
 * Class SkipResult.
 *
 * Represents a single skipped test.
 *
 * TODO: Rename to "ErrorResult".
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class SkipResult
{
    /**
     * @param string $identifier The full identifier of the test (e.g., "ClassName::methodName" or "ClassName::methodName [scenarioName]").
     * @param string $message The message describing why the test was skipped.
     */
    public function __construct(
        public readonly string $identifier,
        public readonly string $message
    ) {
    }
}
