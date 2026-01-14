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
 * Class Product.
 *
 * Represents a product with a price.
 * Tests instance methods with class-typed parameters where auto-generation is needed.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Product
{
    #[Fixture('default', args: ['Widget', 1000])]
    #[Fixture('expensive', args: ['Premium Widget', 5000])]
    public function __construct(
        private readonly string $name,
        private readonly int $pricePence
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): Money
    {
        return Money::fromInt($this->pricePence);
    }

    /**
     * Compares this product's price with another Money value.
     * This tests instance method with class-typed parameter requiring auto-generated scenario.
     */
    public function isPricedAbove(Money $threshold): bool
    {
        return $this->pricePence > $threshold->getPence();
    }

    /**
     * Checks if this product is more expensive than another product.
     * This tests instance method with class-typed parameter where the parameter class
     * also has a constructor with promoted properties.
     */
    public function isMoreExpensiveThan(Product $other): bool
    {
        return $this->pricePence > $other->pricePence;
    }

    /**
     * Creates a bundle with another product.
     * This tests instance method returning a class that has promoted properties typed as classes.
     */
    public function bundleWith(Product $other): ProductBundle
    {
        return new ProductBundle($this, $other);
    }
}
