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

namespace PHPSure\Tests\Functional;

use PHPSure\Config\ConfigResolver;
use PHPSure\Io\RecordingOutput;

/**
 * Class ConfiguredAppFunctionalTest.
 *
 * Functional tests for running PHPSure with a configured app.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ConfiguredAppFunctionalTest extends AbstractFunctionalTestCase
{
    private string $fixturesPath;

    public function setUp(): void
    {
        $this->fixturesPath = __DIR__ . '/Fixtures/MyConfiguredApp';
    }

    public function testRunScansConfiguredAppAndReturnsCorrectResults(): void
    {
        // Load the config from phpsure.config.php.
        $configResolver = new ConfigResolver($this->fixturesPath);
        $config = $configResolver->resolveConfig();

        // Get the PhpSure binary from the implementation.
        $implementation = $config->getImplementation();
        $phpSureBinary = $implementation->getPhpSureBinary();

        // Get the RecordingOutput instances from the implementation.
        /** @var RecordingOutput $stdout */
        $stdout = $implementation->getStdout();
        /** @var RecordingOutput $stderr */
        $stderr = $implementation->getStderr();

        // Run the scan on the fixture app's src directory.
        $argv = ['phpsure', 'scan', $this->fixturesPath . '/src'];
        $exitCode = $phpSureBinary->run($argv);

        // Should exit with success (0) as all tests should pass.
        static::assertSame(0, $exitCode);

        // Verify stdout contains the summary with passes.
        $stdoutOutput = $stdout->getOutput();
        static::assertStringContainsString('Passed: 5', $stdoutOutput);
        static::assertStringContainsString('Failed: 0', $stdoutOutput);
        static::assertStringContainsString('Warnings: 0', $stdoutOutput);
        static::assertStringContainsString('Skipped: 0', $stdoutOutput);

        // Verify stderr is empty (no errors).
        static::assertSame('', $stderr->getOutput());
    }
}
