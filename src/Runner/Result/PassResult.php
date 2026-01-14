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
 * Class PassResult.
 *
 * Represents a single passed test.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class PassResult
{
    /**
     * @param string $identifier The full identifier of the test (e.g., "ClassName::methodName" or "ClassName::methodName [scenarioName]").
     */
    public function __construct(
        public readonly string $identifier
    ) {
    }
}
