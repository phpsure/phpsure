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

namespace PHPSure\Tests\Unit\Config;

use PHPSure\Config\Config;
use PHPSure\Implementation\Implementation;
use PHPSure\Implementation\ImplementationInterface;
use PHPSure\Tests\AbstractTestCase;

/**
 * Class ConfigTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ConfigTest extends AbstractTestCase
{
    private Config $config;

    protected function setUp(): void
    {
        parent::setUp();

        $this->config = new Config();
    }

    public function testGetImplementationReturnsImplementationInstance(): void
    {
        $implementation = $this->config->getImplementation();

        static::assertInstanceOf(Implementation::class, $implementation);
    }

    public function testGetImplementationReturnsSameInstanceOnSubsequentCalls(): void
    {
        $implementation1 = $this->config->getImplementation();
        $implementation2 = $this->config->getImplementation();

        static::assertSame($implementation1, $implementation2);
    }

    public function testSetImplementationAllowsCustomImplementation(): void
    {
        $customImplementation = mock(ImplementationInterface::class);

        $this->config->setImplementation($customImplementation);

        static::assertSame($customImplementation, $this->config->getImplementation());
    }

    public function testSetImplementationReturnsConfigForFluentInterface(): void
    {
        $customImplementation = mock(ImplementationInterface::class);

        $result = $this->config->setImplementation($customImplementation);

        static::assertSame($this->config, $result);
    }
}
