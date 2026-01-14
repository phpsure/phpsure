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
use PHPSure\Config\ConfigResolver;
use PHPSure\Exception\InvalidConfigurationException;
use PHPSure\Exception\MissingConfigurationException;
use PHPSure\Tests\AbstractTestCase;

/**
 * Class ConfigResolverTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ConfigResolverTest extends AbstractTestCase
{
    private ConfigResolver $configResolver;
    private string $fixturesPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixturesPath = __DIR__ . '/../../Functional/Fixtures/MyConfiguredApp';
        $this->configResolver = new ConfigResolver($this->fixturesPath);
    }

    public function testResolveConfigReturnsConfigInstance(): void
    {
        $config = $this->configResolver->resolveConfig();

        static::assertInstanceOf(Config::class, $config);
    }

    public function testResolveConfigThrowsWhenConfigFileDoesNotExist(): void
    {
        $configResolver = new ConfigResolver('/nonexistent/path');

        $this->expectException(MissingConfigurationException::class);
        $this->expectExceptionMessage('PHPSure config file /nonexistent/path/phpsure.config.php is required but was not found');

        $configResolver->resolveConfig();
    }

    public function testResolveConfigThrowsWhenConfigFileDoesNotReturnConfigInstance(): void
    {
        $tempDir = sys_get_temp_dir() . '/phpsure_test_' . uniqid();
        mkdir($tempDir);

        try {
            file_put_contents($tempDir . '/phpsure.config.php', '<?php return "not a config";');

            $configResolver = new ConfigResolver($tempDir);

            $this->expectException(InvalidConfigurationException::class);
            $this->expectExceptionMessageMatches('/Return value of module .* is expected to be an instance of .* but was not/');

            $configResolver->resolveConfig();
        } finally {
            unlink($tempDir . '/phpsure.config.php');
            rmdir($tempDir);
        }
    }
}
