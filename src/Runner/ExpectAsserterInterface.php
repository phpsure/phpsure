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

use RuntimeException;

/**
 * Interface ExpectAsserterInterface.
 *
 * Asserts that results match expected values.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface ExpectAsserterInterface
{
    /**
     * Asserts that the result matches the expected value.
     *
     * @param mixed $result The actual result.
     * @param mixed $expect The expected value.
     * @param string $callableLabel The callable label for error messages.
     * @throws RuntimeException When the result does not match the expected value.
     */
    public function assertExpect(mixed $result, mixed $expect, string $callableLabel): void;
}
