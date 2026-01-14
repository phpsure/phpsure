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

use Composer\Autoload\ClassLoader;
use PHPSure\Assert\TypeAsserter;
use PHPSure\Bin\PhpSureBinary;
use PHPSure\Bin\PhpSureBinaryInterface;
use PHPSure\Bin\ScanCommand;
use PHPSure\Config\Config;
use PHPSure\Config\ConfigResolver;
use PHPSure\Config\ProjectRootResolver;
use PHPSure\Discovery\Scanner;
use PHPSure\Generator\ArgumentResolver;
use PHPSure\Generator\FixtureMaterialiser;
use PHPSure\Generator\FixtureResolver;
use PHPSure\Generator\ParameterResolver;
use PHPSure\Generator\TokenGenerator;
use PHPSure\Generator\TypeBasedTokenGenerator;
use PHPSure\Implementation\ImplementationInterface;
use PHPSure\Io\OutputInterface;
use PHPSure\Io\RecordingOutput;
use PHPSure\Runner\ClassMemberTester;
use PHPSure\Runner\ClassTester;
use PHPSure\Runner\ExpectAsserter;
use PHPSure\Runner\FunctionTester;
use PHPSure\Runner\InstanceCreator;
use PHPSure\Runner\MethodTester;
use PHPSure\Runner\Runner;
use PHPSure\Runner\RunnerInterface;
use PHPSure\Runner\ScenarioManager;
use ReflectionClass;

/**
 * Class ConfigResolutionFunctionalTest.
 *
 * Functional tests for phpsure.config.php discovery and resolution.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ConfigResolutionFunctionalTest extends AbstractFunctionalTestCase
{
    private ConfigResolver $configResolver;
    private string $fixturesPath;

    public function setUp(): void
    {
        $this->fixturesPath = __DIR__ . '/Fixtures/MyConfiguredApp';

        $this->configResolver = new ConfigResolver(
            $this->fixturesPath,
            'phpsure.config.php'
        );
    }

    public function testResolveConfigLoadsPhpSureConfigFile(): void
    {
        $config = $this->configResolver->resolveConfig();

        static::assertInstanceOf(Config::class, $config);
    }

    public function testResolveConfigReturnsConfigWithDefaultImplementation(): void
    {
        $config = $this->configResolver->resolveConfig();
        $implementation = $config->getImplementation();

        static::assertNotNull($implementation);
        $phpSureBinary = $implementation->getPhpSureBinary();

        static::assertNotNull($phpSureBinary);
    }

    public function testConfigCanBeCustomizedWithSetImplementation(): void
    {
        $config = $this->configResolver->resolveConfig();

        // Verify we can set a custom implementation.
        $customImplementation = new class implements ImplementationInterface {
            private RunnerInterface $runner;
            private OutputInterface $stderr;
            private OutputInterface $stdout;

            public function __construct()
            {
                $scanner = new Scanner();
                $fixtureResolver = new FixtureResolver();
                $tokenGenerator = new TokenGenerator(
                    new TypeBasedTokenGenerator(
                        $fixtureResolver,
                        new FixtureMaterialiser(
                            $fixtureResolver,
                            new ArgumentResolver()
                        ),
                        new ParameterResolver()
                    )
                );
                $typeAsserter = new TypeAsserter();
                $fixtureResolver = new FixtureResolver();
                $argumentResolver = new ArgumentResolver();
                $fixtureMaterialiser = new FixtureMaterialiser($fixtureResolver, $argumentResolver);
                $scenarioManager = new ScenarioManager();
                $instanceCreator = new InstanceCreator($scenarioManager, $argumentResolver, $fixtureMaterialiser, $tokenGenerator);
                $expectAsserter = new ExpectAsserter();
                $methodTester = new MethodTester(
                    $typeAsserter,
                    $instanceCreator,
                    $scenarioManager,
                    $expectAsserter,
                    $argumentResolver,
                    $fixtureMaterialiser
                );
                $classMemberTester = new ClassMemberTester(
                    $scanner,
                    $tokenGenerator,
                    $methodTester
                );
                $classTester = new ClassTester($instanceCreator, $classMemberTester);
                $functionTester = new FunctionTester($tokenGenerator, $typeAsserter);

                $this->runner = new Runner($scanner, $functionTester, $classTester);

                $this->stdout = new RecordingOutput();
                $this->stderr = new RecordingOutput();
            }

            public function getPhpSureBinary(): PhpSureBinaryInterface
            {
                return new PhpSureBinary(
                    new ScanCommand($this->runner, $this->stdout, $this->stderr),
                    $this->stderr
                );
            }

            public function getRunner(): RunnerInterface
            {
                return $this->runner;
            }

            public function getStderr(): OutputInterface
            {
                return $this->stderr;
            }

            public function getStdout(): OutputInterface
            {
                return $this->stdout;
            }
        };

        $config->setImplementation($customImplementation);

        static::assertSame($customImplementation, $config->getImplementation());
    }

    public function testProjectRootResolverFindsCorrectRoot(): void
    {
        // Use the actual ClassLoader from vendor.
        $classLoaderReflection = new ReflectionClass(ClassLoader::class);
        $projectRootResolver = new ProjectRootResolver($classLoaderReflection);

        $projectRoot = $projectRootResolver->resolveProjectRoot();

        // The project root should be 3 directories up from vendor/composer/ClassLoader.php.
        static::assertStringEndsWith('phpsure', $projectRoot);
    }
}
