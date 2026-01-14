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
 * Class Money.
 *
 * Represents a monetary value.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Money
{
    private function __construct(
        private readonly int $pence
    ) {
    }

    #[Fixture('default', args: [1000])]
    #[Fixture('gbp10', args: [1000])]
    #[Fixture('gbp5', args: [500])]
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

    public function add(Money $other): self
    {
        return new self($this->pence + $other->pence);
    }

    public function isGreaterThan(Money $other): bool
    {
        return $this->pence > $other->pence;
    }
}
