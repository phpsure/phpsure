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
 * Class ProductBundle.
 *
 * Represents a bundle of two products.
 * Tests constructor with promoted properties typed as classes requiring auto-generated fixtures.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ProductBundle
{
    #[Fixture(
        'default',
        args: [
            ['fixture' => [Product::class, 'default']],
            ['fixture' => [Product::class, 'expensive']]
        ]
    )]
    public function __construct(
        private readonly Product $product1,
        private readonly Product $product2
    ) {
    }

    public function getProduct1(): Product
    {
        return $this->product1;
    }

    public function getProduct2(): Product
    {
        return $this->product2;
    }

    public function getTotalPrice(): Money
    {
        $total = $this->product1->getPrice()->getPence() + $this->product2->getPrice()->getPence();
        return Money::fromInt($total);
    }

    /**
     * Checks if the bundle total is above a threshold.
     * This tests instance method with class-typed parameter on a class that has
     * promoted properties typed as classes.
     */
    public function isTotalAbove(Money $threshold): bool
    {
        return $this->getTotalPrice()->isGreaterThan($threshold);
    }
}
