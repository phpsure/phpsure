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
 * Class Fixture.
 *
 * Attribute for defining fixtures on constructors and static factory methods.
 * A Fixture defines both a fixture (for creating instances) and a test scenario.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Fixture implements FixtureInterface
{
    /**
     * @param string $name The name of the fixture. Defaults to 'default'.
     * @param string|null $description Optional description of the fixture.
     * @param array<mixed> $args Positional array of arguments, in parameter order.
     * @param mixed $expect Optional expected value. For POC, supports "type check" and scalar equality.
     */
    public function __construct(
        private readonly string $name = self::DEFAULT_NAME,
        private readonly ?string $description = null,
        private readonly array $args = [],
        // TODO: Support either scalars for expected value or an enum case for "type check".
        private readonly mixed $expect = 'type check'
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
    public function getName(): string
    {
        return $this->name;
    }
}
