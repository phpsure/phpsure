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

/**
 * Class Order.
 *
 * Represents an order in the system.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Order
{
    public function __construct(
        private readonly User $user,
        private readonly Money $total
    ) {
    }

    #[Fixture(
        'default',
        args: [
            ['fixture' => [User::class, 'default']],
            ['fixture' => [Money::class, 'gbp10']]
        ]
    )]
    public static function create(User $user, Money $total): self
    {
        return new self($user, $total);
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getTotal(): Money
    {
        return $this->total;
    }

    public function getTotalPounds(): float
    {
        return $this->total->getPounds();
    }

    public function isHighValue(): bool
    {
        return $this->total->isGreaterThan(Money::fromInt(5000));
    }
}
