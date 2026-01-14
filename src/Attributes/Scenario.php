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

namespace PHPSure\Attributes;

use Attribute;

/**
 * Class Scenario.
 *
 * Attribute for defining test scenarios on methods and functions.
 * Scenarios define test cases but do not define fixtures.
 * Use the Fixture attribute to define both a fixture and a test scenario.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Scenario implements ScenarioInterface
{
    /**
     * @param string|null $description Optional description of the scenario.
     * @param array<mixed> $args Positional array of arguments, in parameter order.
     * @param mixed $expect Optional expected value. For POC, supports "type check" and scalar equality.
     * @param string $instance Name of the fixture to use for creating the instance.
     *                         Only applicable to instance method scenarios. Defaults to 'default' if not specified.
     */
    public function __construct(
        private readonly ?string $description = null,
        private readonly array $args = [],
        // TODO: Support either scalars for expected value or an enum case for "type check".
        private readonly mixed $expect = 'type check',
        private readonly string $instance = self::DEFAULT_INSTANCE
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getArguments(): array
    {
        return $this->args;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @inheritDoc
     */
    public function getExpectation(): mixed
    {
        return $this->expect;
    }

    /**
     * @inheritDoc
     */
    public function getInstanceFixtureName(): string
    {
        return $this->instance;
    }
}
