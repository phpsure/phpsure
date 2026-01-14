# PHPSure

[![Build Status](https://github.com/phpsure/phpsure/workflows/CI/badge.svg)](https://github.com/phpsure/phpsure/actions?query=workflow%3ACI)

[PRE-ALPHA] Not yet ready for general use; use for experimentation and feedback only.

An automated contract testing framework for PHP that validates your code's type contracts at runtime.

## What is PHPSure?

PHPSure automatically tests your functions and methods to ensure they honour their type declarations. It bridges the gap between static type checking and unit testing by:

- **Automatically generating test inputs** for your functions and methods based on their type hints
- **Validating return types** match their declarations
- **Testing with custom scenarios** using PHP attributes to define specific test cases
- **Catching type contract violations** before they become runtime bugs

Think of it as automated contract testing that ensures your code does what its type signatures promise.

## Installation

```bash
composer require --dev phpsure/phpsure
```

## Command Line Usage

### Scan a directory or file

```bash
vendor/bin/phpsure scan <directory-or-file>
```

**Examples:**

```bash
# Scan an entire directory
vendor/bin/phpsure scan src/

# Scan a specific file
vendor/bin/phpsure scan src/MyClass.php
```

The `scan` command will:
1. Discover all functions and classes in the specified path
2. Generate test inputs based on type hints
3. Execute each function/method with the generated inputs
4. Verify that return values match their declared types and optionally expected return values
5. Report any type contract violations

### Exit Codes

- `0` - All tests passed
- `1` - Configuration error or invalid usage
- `3` - One or more test failures detected

## How It Works

PHPSure uses PHP's Reflection API to discover your code and automatically test it:

### Basic Type Checking

For functions and methods without explicit test scenarios, PHPSure automatically generates appropriate inputs based on parameter types and validates the return type:

```php
<?php

function add(int $a, int $b): int
{
    return $a + $b;
}
```

PHPSure will automatically test this function with generated integer values and verify the result is an integer.

### Custom Test Scenarios

Use the `#[Scenario]` attribute to define specific test cases:

```php
<?php

use PHPSure\Attributes\Scenario;

#[Scenario(description: 'adds positive numbers', args: [2, 3], expect: 5)]
#[Scenario(description: 'adds negative numbers', args: [-2, -3], expect: -5)]
function add(int $a, int $b): int
{
    return $a + $b;
}
```

### Fixture-Based Testing

For classes with complex constructors, use the `#[Fixture]` attribute to define how instances should be created:

```php
<?php

use PHPSure\Attributes\Fixture;
use PHPSure\Attributes\Scenario;

class Calculator
{
    #[Fixture(name: 'default', args: [10])]
    public function __construct(private int $precision) {}

    #[Scenario(args: [2.5, 3.7], expect: 6.2, instance: 'default')]
    public function add(float $a, float $b): float
    {
        return round($a + $b, $this->precision);
    }
}
```

Note that Fixtures are also Scenarios - they'll be executed as test cases in the same way too.

## Test Results

PHPSure categorizes test results into:

- **Pass** ✓ - Function/method returned a value matching its type declaration
- **Fail** ✗ - Type contract violation detected
- **Skip** ⊘ - Test skipped (e.g., due to missing dependencies or exceptions during execution)
- **Warning** ⚠ - Potential issue detected (e.g., private constructor without fixtures)

## Why PHPSure?

Traditional unit tests require you to manually write test cases for every function and method. PHPSure automates this process by:

1. **Reducing boilerplate** - No need to write basic type validation tests
2. **Ensuring consistency** - Every function gets tested, not just the ones you remember to test
3. **Catching regressions** - Automatically detects when code changes break type contracts
4. **Complementing static analysis** - Validates runtime behavior, not just static types

PHPSure doesn't replace _all of_ your unit tests - it complements them by handling the tedious work of validating type contracts, letting you focus your unit tests on business logic and edge cases.
