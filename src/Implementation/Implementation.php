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

namespace PHPSure\Implementation;

use PHPSure\Assert\TypeAsserter;
use PHPSure\Bin\PhpSureBinary;
use PHPSure\Bin\PhpSureBinaryInterface;
use PHPSure\Bin\ScanCommand;
use PHPSure\Discovery\Scanner;
use PHPSure\Generator\ArgumentResolver;
use PHPSure\Generator\FixtureMaterialiser;
use PHPSure\Generator\FixtureResolver;
use PHPSure\Generator\ParameterResolver;
use PHPSure\Generator\TokenGenerator;
use PHPSure\Generator\TypeBasedTokenGenerator;
use PHPSure\Io\Output;
use PHPSure\Io\OutputInterface;
use PHPSure\Runner\ClassMemberTester;
use PHPSure\Runner\ClassTester;
use PHPSure\Runner\ExpectAsserter;
use PHPSure\Runner\FunctionTester;
use PHPSure\Runner\InstanceCreator;
use PHPSure\Runner\MethodTester;
use PHPSure\Runner\Runner;
use PHPSure\Runner\RunnerInterface;
use PHPSure\Runner\ScenarioManager;

/**
 * Class Implementation.
 *
 * Default implementation of PHPSure.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Implementation implements ImplementationInterface
{
    private ?PhpSureBinaryInterface $phpSureBinary = null;
    private ?RunnerInterface $runner = null;
    private OutputInterface $stderr;
    private OutputInterface $stdout;

    /**
     * @inheritDoc
     */
    public function getPhpSureBinary(): PhpSureBinaryInterface
    {
        if ($this->phpSureBinary === null) {
            $runner = $this->getRunner();
            $this->stdout = new Output(STDOUT);
            $this->stderr = new Output(STDERR);

            $this->phpSureBinary = new PhpSureBinary(
                new ScanCommand($runner, $this->stdout, $this->stderr),
                $this->stderr
            );
        }

        return $this->phpSureBinary;
    }

    /**
     * @inheritDoc
     */
    public function getRunner(): RunnerInterface
    {
        if ($this->runner === null) {
            $scanner = new Scanner();
            $fixtureResolver = new FixtureResolver();
            $argumentResolver = new ArgumentResolver();
            $fixtureMaterialiser = new FixtureMaterialiser($fixtureResolver, $argumentResolver);
            $tokenGenerator = new TokenGenerator(
                new TypeBasedTokenGenerator(
                    $fixtureResolver,
                    $fixtureMaterialiser,
                    new ParameterResolver()
                )
            );
            $typeAsserter = new TypeAsserter();
            $scenarioManager = new ScenarioManager();
            $instanceCreator = new InstanceCreator(
                $scenarioManager,
                $argumentResolver,
                $fixtureMaterialiser,
                $tokenGenerator
            );
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
        }

        return $this->runner;
    }

    /**
     * @inheritDoc
     */
    public function getStderr(): OutputInterface
    {
        return $this->stderr;
    }

    /**
     * @inheritDoc
     */
    public function getStdout(): OutputInterface
    {
        return $this->stdout;
    }
}
