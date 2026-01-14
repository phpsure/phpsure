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
 * Class CalculatorMissingDefaultScenario.
 *
 * Calculator with fixtures but no 'default' fixture.
 * This should fail when instance method scenarios don't specify an instance.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class CalculatorMissingDefaultFixture
{
    #[Fixture('base5', args: [5])]
    public function __construct(
        private readonly int $base
    ) {
    }

    /**
     * Adds a value to the base.
     * Scenario without specifying instance - should fail because no 'default' fixture exists.
     */
    #[Scenario(args: [5], expect: 10)]
    public function add(int $value): int
    {
        return $this->base + $value;
    }
}
