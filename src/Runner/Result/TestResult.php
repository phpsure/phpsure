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
 * Class TestResult.
 *
 * Represents the result of running tests.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class TestResult
{
    /**
     * @param array<PassResult> $passes Array of passed test results.
     * @param array<FailResult> $failures Array of failed test results.
     * @param array<SkipResult> $skips Array of skipped test results.
     * @param array<WarningResult> $warnings Array of warning results.
     */
    public function __construct(
        private readonly array $passes,
        private readonly array $failures,
        private readonly array $skips,
        private readonly array $warnings
    ) {
    }

    /**
     * Fetches the array of passed test results.
     *
     * @return array<PassResult> Array of passed test results.
     */
    public function getPasses(): array
    {
        return $this->passes;
    }

    /**
     * Fetches the array of failed test results.
     *
     * @return array<FailResult> Array of failed test results.
     */
    public function getFailures(): array
    {
        return $this->failures;
    }

    /**
     * Fetches the array of skipped test results.
     *
     * @return array<SkipResult> Array of skipped test results.
     */
    public function getSkips(): array
    {
        return $this->skips;
    }

    /**
     * Fetches the array of warning results.
     *
     * @return array<WarningResult> Array of warning results.
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    /**
     * Fetches the number of passed tests.
     *
     * @return int The number of passed tests.
     */
    public function getPassCount(): int
    {
        return count($this->passes);
    }

    /**
     * Fetches the number of failed tests.
     *
     * @return int The number of failed tests.
     */
    public function getFailCount(): int
    {
        return count($this->failures);
    }

    /**
     * Fetches the number of skipped tests.
     *
     * @return int The number of skipped tests.
     */
    public function getSkipCount(): int
    {
        return count($this->skips);
    }

    /**
     * Fetches the number of warnings.
     *
     * @return int The number of warnings.
     */
    public function getWarnCount(): int
    {
        return count($this->warnings);
    }

    /**
     * Fetches whether any tests failed.
     *
     * @return bool True if any tests failed, false otherwise.
     */
    public function hasFailures(): bool
    {
        return count($this->failures) > 0;
    }

    /**
     * Fetches the total number of tests run.
     *
     * @return int The total number of tests.
     */
    public function getTotalCount(): int
    {
        return count($this->passes) + count($this->failures) + count($this->skips) + count($this->warnings);
    }

    /**
     * Builds a MethodResult for a specific class method.
     *
     * This filters all results (passes, failures, warnings, skips) to only include
     * those matching the specified class and method name.
     *
     * @param string $className The fully qualified class name.
     * @param string $methodName The method name (without parentheses or operators).
     * @return MethodResult The filtered results for this method.
     */
    public function getMethodResult(string $className, string $methodName): MethodResult
    {
        // Normalize the class name (remove leading backslash if present)
        $className = ltrim($className, '\\');

        // Build possible identifier patterns for this method
        // Static methods: ClassName::methodName
        // Instance methods: ClassName->methodName()
        $staticPattern = $className . '::' . $methodName;
        $instancePattern = $className . '->' . $methodName . '()';

        // Filter results that match either pattern
        $filterByMethod = function ($result) use ($staticPattern, $instancePattern): bool {
            // Check if identifier starts with either pattern
            // This handles both exact matches and scenario-suffixed identifiers like "ClassName::method [scenario]"
            return str_starts_with($result->identifier, $staticPattern) ||
                   str_starts_with($result->identifier, $instancePattern);
        };

        $passes = array_values(array_filter($this->passes, $filterByMethod));
        $failures = array_values(array_filter($this->failures, $filterByMethod));
        $skips = array_values(array_filter($this->skips, $filterByMethod));
        $warnings = array_values(array_filter($this->warnings, $filterByMethod));

        // Use the instance pattern as the identifier (more common)
        $identifier = str_contains($methodName, '::') ? $staticPattern : $instancePattern;

        return new MethodResult($identifier, $passes, $failures, $skips, $warnings);
    }

    /**
     * Builds a FunctionResult for a specific function.
     *
     * This filters all results (passes, failures, warnings, skips) to only include
     * those matching the specified function name.
     *
     * @param string $functionName The fully qualified function name (e.g., "namespace\\functionname").
     * @return FunctionResult The filtered results for this function.
     */
    public function getFunctionResult(string $functionName): FunctionResult
    {
        // Normalize the function name (remove leading backslash if present, convert to lowercase for matching)
        $normalizedFunctionName = strtolower(ltrim($functionName, '\\'));

        // Build the identifier pattern for this function (lowercase for case-insensitive matching)
        // Functions: namespace\functionname()
        $functionPattern = $normalizedFunctionName . '()';

        // Filter results that match the pattern
        $filterByFunction = function ($result) use ($functionPattern): bool {
            // Check if identifier starts with the pattern
            // This handles both exact matches and scenario-suffixed identifiers like "namespace\\function() [scenario]"
            return str_starts_with(strtolower($result->identifier), $functionPattern);
        };

        $passes = array_values(array_filter($this->passes, $filterByFunction));
        $failures = array_values(array_filter($this->failures, $filterByFunction));
        $skips = array_values(array_filter($this->skips, $filterByFunction));
        $warnings = array_values(array_filter($this->warnings, $filterByFunction));

        // Use the original case from the first matching result if available, otherwise use the normalized pattern.
        $identifier = $functionPattern;
        if (!empty($passes)) {
            $identifier = $passes[0]->identifier;
        } elseif (!empty($failures)) {
            $identifier = $failures[0]->identifier;
        } elseif (!empty($skips)) {
            $identifier = $skips[0]->identifier;
        } elseif (!empty($warnings)) {
            $identifier = $warnings[0]->identifier;
        }

        return new FunctionResult($identifier, $passes, $failures, $skips, $warnings);
    }

    /**
     * Prints a summary of the test results.
     *
     * @return string The summary.
     */
    public function getSummary(): string
    {
        $summary = sprintf(
            "PHPSure Scan Results:\n" .
            "  Passed: %d\n" .
            "  Failed: %d\n" .
            "  Warnings: %d\n" .
            "  Skipped: %d\n" .
            "  Total: %d\n",
            $this->getPassCount(),
            $this->getFailCount(),
            $this->getWarnCount(),
            $this->getSkipCount(),
            $this->getTotalCount()
        );

        if (!empty($this->failures)) {
            $summary .= "\nFailures:\n";
            foreach ($this->failures as $failure) {
                $summary .= sprintf("  - FAIL: %s - %s\n", $failure->identifier, $failure->message);
            }
        }

        if (!empty($this->warnings)) {
            $summary .= "\nWarnings:\n";
            foreach ($this->warnings as $warning) {
                $summary .= sprintf("  - WARN: %s - %s\n", $warning->identifier, $warning->message);
            }
        }

        if (!empty($this->skips)) {
            $summary .= "\nSkipped:\n";
            foreach ($this->skips as $skip) {
                $summary .= sprintf("  - SKIP: %s - %s\n", $skip->identifier, $skip->message);
            }
        }

        return $summary;
    }
}
