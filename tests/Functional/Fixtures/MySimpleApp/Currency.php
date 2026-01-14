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
 * Class Currency.
 *
 * Represents a currency code.
 * This class has a private constructor and static factory methods,
 * but intentionally does NOT define a 'default' fixture.
 * This tests the warning behavior when auto-generation is needed.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Currency
{
    private function __construct(
        private readonly string $code
    ) {
    }

    #[Fixture('usd', args: ['USD'])]
    #[Fixture('gbp', args: ['GBP'])]
    #[Fixture('eur', args: ['EUR'])]
    public static function fromCode(string $code): self
    {
        return new self($code);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function isSameCurrency(Currency $other): bool
    {
        return $this->code === $other->code;
    }
}
