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
 * Class FunctionResult.
 *
 * Represents the results for a specific function within a test run.
 * Provides convenient access to passes, failures, warnings, and skips for a single function.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class FunctionResult
{
    /**
     * @param string $functionIdentifier The function identifier (e.g., "namespace\\functionname()").
     * @param array<PassResult> $passes Array of passed test results for this function.
     * @param array<FailResult> $failures Array of failed test results for this function.
     * @param array<SkipResult> $skips Array of skipped test results for this function.
     * @param array<WarningResult> $warnings Array of warning results for this function.
     */
    public function __construct(
        private readonly string $functionIdentifier,
        private readonly array $passes,
        private readonly array $failures,
        private readonly array $skips,
        private readonly array $warnings
    ) {
    }

    /**
     * Fetches the function identifier.
     *
     * @return string The function identifier.
     */
    public function getIdentifier(): string
    {
        return $this->functionIdentifier;
    }

    /**
     * Fetches the array of passed test results for this function.
     *
     * @return array<PassResult> Array of passed test results.
     */
    public function getPasses(): array
    {
        return $this->passes;
    }

    /**
     * Fetches the array of failed test results for this function.
     *
     * @return array<FailResult> Array of failed test results.
     */
    public function getFailures(): array
    {
        return $this->failures;
    }

    /**
     * Fetches the array of skipped test results for this function.
     *
     * @return array<SkipResult> Array of skipped test results.
     */
    public function getSkips(): array
    {
        return $this->skips;
    }

    /**
     * Fetches the array of warning results for this function.
     *
     * @return array<WarningResult> Array of warning results.
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    /**
     * Fetches whether this function has any passes.
     *
     * @return bool True if there are passes, false otherwise.
     */
    public function hasPasses(): bool
    {
        return count($this->passes) > 0;
    }

    /**
     * Fetches whether this function has any failures.
     *
     * @return bool True if there are failures, false otherwise.
     */
    public function hasFailures(): bool
    {
        return count($this->failures) > 0;
    }

    /**
     * Fetches whether this function has any skips.
     *
     * @return bool True if there are skips, false otherwise.
     */
    public function hasSkips(): bool
    {
        return count($this->skips) > 0;
    }

    /**
     * Fetches whether this function has any warnings.
     *
     * @return bool True if there are warnings, false otherwise.
     */
    public function hasWarnings(): bool
    {
        return count($this->warnings) > 0;
    }

    /**
     * Fetches the first warning for this function, or null if there are no warnings.
     *
     * @return WarningResult|null The first warning, or null.
     */
    public function getFirstWarning(): ?WarningResult
    {
        return $this->warnings[0] ?? null;
    }

    /**
     * Fetches the first failure for this function, or null if there are no failures.
     *
     * @return FailResult|null The first failure, or null.
     */
    public function getFirstFailure(): ?FailResult
    {
        return $this->failures[0] ?? null;
    }

    /**
     * Fetches the first skip for this function, or null if there are no skips.
     *
     * @return SkipResult|null The first skip, or null.
     */
    public function getFirstSkip(): ?SkipResult
    {
        return $this->skips[0] ?? null;
    }

    /**
     * Fetches the first pass for this function, or null if there are no passes.
     *
     * @return PassResult|null The first pass, or null.
     */
    public function getFirstPass(): ?PassResult
    {
        return $this->passes[0] ?? null;
    }
}
