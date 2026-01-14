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

namespace PHPSure\Tests\Functional\Fixtures\MySimpleApp;

use PHPSure\Attributes\Fixture;
use PHPSure\Attributes\Scenario;

/**
 * Class MoneyWithScenarios.
 *
 * Similar to Money but with explicit scenarios for instance methods.
 * Tests instance methods with class-typed parameters using explicit scenarios.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class MoneyWithScenarios
{
    private function __construct(
        private readonly int $pence
    ) {
    }

    #[Fixture('default', args: [1000])]
    #[Fixture('gbp10', args: [1000])]
    #[Fixture('gbp5', args: [500])]
    #[Fixture('gbp20', args: [2000])]
    public static function fromInt(int $pence): self
    {
        return new self($pence);
    }

    public function getPence(): int
    {
        return $this->pence;
    }

    public function getPounds(): float
    {
        return $this->pence / 100;
    }

    /**
     * Adds another Money value.
     * Tests instance method with class-typed parameter using explicit fixture.
     */
    #[Scenario(
        'add_gbp5_to_gbp10',
        args: [['fixture' => [self::class, 'gbp5']]],
        expect: 'type check',
        instance: 'gbp10'
    )]
    #[Scenario(
        'add_gbp10_to_gbp5',
        args: [['fixture' => [self::class, 'gbp10']]],
        expect: 'type check',
        instance: 'gbp5'
    )]
    public function add(MoneyWithScenarios $other): self
    {
        return new self($this->pence + $other->pence);
    }

    /**
     * Compares with another Money value.
     * Tests instance method with class-typed parameter using explicit fixture.
     */
    #[Scenario(
        'gbp10_greater_than_gbp5',
        args: [['fixture' => [self::class, 'gbp5']]],
        expect: true,
        instance: 'gbp10'
    )]
    #[Scenario(
        'gbp5_not_greater_than_gbp10',
        args: [['fixture' => [self::class, 'gbp10']]],
        expect: false,
        instance: 'gbp5'
    )]
    public function isGreaterThan(MoneyWithScenarios $other): bool
    {
        return $this->pence > $other->pence;
    }
}
