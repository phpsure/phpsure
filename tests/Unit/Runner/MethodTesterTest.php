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

namespace PHPSure\Tests\Unit\Runner;

use Mockery\MockInterface;
use PHPSure\Assert\TypeAsserter;
use PHPSure\Attributes\Scenario;
use PHPSure\Exception\TypeMismatchException;
use PHPSure\Generator\ArgumentResolverInterface;
use PHPSure\Generator\FixtureMaterialiserInterface;
use PHPSure\Runner\ExpectAsserterInterface;
use PHPSure\Runner\InstanceCreatorInterface;
use PHPSure\Runner\MethodTester;
use PHPSure\Runner\Result\FailResult;
use PHPSure\Runner\Result\PassResult;
use PHPSure\Runner\Result\SkipResult;
use PHPSure\Runner\Result\WarningResult;
use PHPSure\Runner\ScenarioManagerInterface;
use PHPSure\Tests\AbstractTestCase;
use ReflectionMethod;
use ReflectionType;
use RuntimeException;

/**
 * Class MethodTesterTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class MethodTesterTest extends AbstractTestCase
{
    private MockInterface&ArgumentResolverInterface $argumentResolver;
    private MockInterface&ExpectAsserterInterface $expectAsserter;
    private MockInterface&FixtureMaterialiserInterface $fixtureMaterialiser;
    private MockInterface&InstanceCreatorInterface $instanceCreator;
    private MethodTester $methodTester;
    private MockInterface&ScenarioManagerInterface $scenarioManager;
    private MockInterface&TypeAsserter $typeAsserter;

    public function setUp(): void
    {
        $this->typeAsserter = mock(TypeAsserter::class);
        $this->instanceCreator = mock(InstanceCreatorInterface::class);
        $this->scenarioManager = mock(ScenarioManagerInterface::class);
        $this->expectAsserter = mock(ExpectAsserterInterface::class);
        $this->argumentResolver = mock(ArgumentResolverInterface::class);
        $this->fixtureMaterialiser = mock(FixtureMaterialiserInterface::class);

        $this->methodTester = new MethodTester(
            $this->typeAsserter,
            $this->instanceCreator,
            $this->scenarioManager,
            $this->expectAsserter,
            $this->argumentResolver,
            $this->fixtureMaterialiser
        );
    }

    public function testTestInstanceMethodAddsPassResultWhenMethodReturnsCorrectTypeWithNoScenarios(): void
    {
        $passes = [];
        $failures = [];
        $skips = [];
        $warnings = [];
        $instance = new MethodTesterTestClass();
        $method = new ReflectionMethod(MethodTesterTestClass::class, 'instanceMethod');
        $invoker = fn () => $method->invoke($instance);

        $this->scenarioManager->expects('getScenarios')
            ->once()
            ->with($method)
            ->andReturn([]);

        $this->typeAsserter->expects('assertMatches')
            ->once()
            ->with('result', \Mockery::type('ReflectionType'));

        $this->methodTester->testInstanceMethod(
            MethodTesterTestClass::class,
            'instanceMethod',
            $method,
            $invoker,
            $instance,
            false,
            $passes,
            $failures,
            $skips,
            $warnings
        );

        $this->assertCount(1, $passes);
        $this->assertInstanceOf(PassResult::class, $passes[0]);
        $this->assertSame(MethodTesterTestClass::class . '->instanceMethod()', $passes[0]->identifier);
        $this->assertCount(0, $failures);
        $this->assertCount(0, $skips);
        $this->assertCount(0, $warnings);
    }

    public function testTestInstanceMethodAddsFailResultWhenReturnTypeMismatchExceptionIsThrownWithNoScenarios(): void
    {
        $passes = [];
        $failures = [];
        $skips = [];
        $warnings = [];
        $instance = new MethodTesterTestClass();
        $method = new ReflectionMethod(MethodTesterTestClass::class, 'instanceMethod');
        $invoker = fn () => $method->invoke($instance);

        $this->scenarioManager->allows('getScenarios')
            ->andReturn([]);

        $mockType = mock(ReflectionType::class);
        $mockType->allows('allowsNull')->andReturn(false);
        $mockType->allows('__toString')->andReturn('string');

        $this->typeAsserter->allows('assertMatches')
            ->andThrow(new TypeMismatchException('test', $mockType));

        $this->methodTester->testInstanceMethod(
            MethodTesterTestClass::class,
            'instanceMethod',
            $method,
            $invoker,
            $instance,
            false,
            $passes,
            $failures,
            $skips,
            $warnings
        );

        $this->assertCount(0, $passes);
        $this->assertCount(1, $failures);
        $this->assertInstanceOf(FailResult::class, $failures[0]);
        $this->assertSame(MethodTesterTestClass::class . '->instanceMethod()', $failures[0]->identifier);
        $this->assertStringContainsString('Return type mismatch', $failures[0]->message);
        $this->assertCount(0, $skips);
        $this->assertCount(0, $warnings);
    }

    public function testTestInstanceMethodAddsSkipResultWhenOtherExceptionIsThrownWithNoScenarios(): void
    {
        $passes = [];
        $failures = [];
        $skips = [];
        $warnings = [];
        $instance = new MethodTesterTestClass();
        $method = new ReflectionMethod(MethodTesterTestClass::class, 'instanceMethod');
        $invoker = fn () => throw new RuntimeException('Something went wrong');

        $this->scenarioManager->allows('getScenarios')
            ->andReturn([]);

        $this->methodTester->testInstanceMethod(
            MethodTesterTestClass::class,
            'instanceMethod',
            $method,
            $invoker,
            $instance,
            false,
            $passes,
            $failures,
            $skips,
            $warnings
        );

        $this->assertCount(0, $passes);
        $this->assertCount(0, $failures);
        $this->assertCount(1, $skips);
        $this->assertInstanceOf(SkipResult::class, $skips[0]);
        $this->assertSame(MethodTesterTestClass::class . '->instanceMethod()', $skips[0]->identifier);
        $this->assertSame('Something went wrong', $skips[0]->message);
        $this->assertCount(0, $warnings);
    }

    public function testTestInstanceMethodAddsWarningResultWhenInstanceIsNullAndConstructorIsPrivate(): void
    {
        $passes = [];
        $failures = [];
        $skips = [];
        $warnings = [];
        $method = new ReflectionMethod(MethodTesterTestClassWithPrivateConstructor::class, 'instanceMethod');
        $invoker = fn () => null;

        $this->scenarioManager->allows('getScenarios')
            ->andReturn([]);

        $this->methodTester->testInstanceMethod(
            MethodTesterTestClassWithPrivateConstructor::class,
            'instanceMethod',
            $method,
            $invoker,
            null,
            false,
            $passes,
            $failures,
            $skips,
            $warnings
        );

        $this->assertCount(0, $passes);
        $this->assertCount(0, $failures);
        $this->assertCount(0, $skips);
        $this->assertCount(1, $warnings);
        $this->assertInstanceOf(WarningResult::class, $warnings[0]);
        $this->assertSame(MethodTesterTestClassWithPrivateConstructor::class . '->instanceMethod()', $warnings[0]->identifier);
        $this->assertStringContainsString('private constructor', $warnings[0]->message);
    }

    public function testTestInstanceMethodAddsFailResultWhenInstanceIsNullAndConstructorIsPublic(): void
    {
        $passes = [];
        $failures = [];
        $skips = [];
        $warnings = [];
        $method = new ReflectionMethod(MethodTesterTestClass::class, 'instanceMethod');
        $invoker = fn () => null;

        $this->scenarioManager->allows('getScenarios')
            ->andReturn([]);

        $this->methodTester->testInstanceMethod(
            MethodTesterTestClass::class,
            'instanceMethod',
            $method,
            $invoker,
            null,
            false,
            $passes,
            $failures,
            $skips,
            $warnings
        );

        $this->assertCount(0, $passes);
        $this->assertCount(1, $failures);
        $this->assertInstanceOf(FailResult::class, $failures[0]);
        $this->assertSame(MethodTesterTestClass::class . '->instanceMethod()', $failures[0]->identifier);
        $this->assertStringContainsString('Cannot create instance', $failures[0]->message);
        $this->assertCount(0, $skips);
        $this->assertCount(0, $warnings);
    }

    public function testTestStaticMethodUsesStaticSeparatorForStaticMethods(): void
    {
        $passes = [];
        $failures = [];
        $skips = [];
        $warnings = [];
        $method = new ReflectionMethod(MethodTesterTestClass::class, 'staticMethod');
        $invoker = fn () => $method->invoke(null);

        $this->scenarioManager->allows('getScenarios')
            ->andReturn([]);

        $this->typeAsserter->allows('assertMatches');

        $this->methodTester->testStaticMethod(
            MethodTesterTestClass::class,
            'staticMethod',
            $method,
            $invoker,
            $passes,
            $failures,
            $skips,
            $warnings
        );

        $this->assertCount(1, $passes);
        $this->assertSame(MethodTesterTestClass::class . '::staticMethod()', $passes[0]->identifier);
    }

    public function testTestInstanceMethodTestsEachScenarioWhenScenariosExist(): void
    {
        $passes = [];
        $failures = [];
        $skips = [];
        $warnings = [];
        $instance = new MethodTesterTestClass();
        $method = new ReflectionMethod(MethodTesterTestClass::class, 'instanceMethod');
        $invoker = fn () => $method->invoke($instance);
        $scenario1 = new Scenario('scenario1', ['arg1'], 'type check', 'default');
        $scenario2 = new Scenario('scenario2', ['arg2'], 'type check', 'default');

        $this->scenarioManager->expects('getScenarios')
            ->once()
            ->with($method)
            ->andReturn([$scenario1, $scenario2]);

        $this->argumentResolver->expects('resolveScenarioArguments')
            ->once()
            ->with(['arg1'], $this->fixtureMaterialiser)
            ->andReturn(['resolved1']);

        $this->argumentResolver->expects('resolveScenarioArguments')
            ->once()
            ->with(['arg2'], $this->fixtureMaterialiser)
            ->andReturn(['resolved2']);

        $this->instanceCreator->expects('createInstanceForFixture')
            ->twice()
            ->with(MethodTesterTestClass::class, 'default', \Mockery::type('bool'))
            ->andReturn($instance);

        $this->typeAsserter->allows('assertMatches');

        $this->methodTester->testInstanceMethod(
            MethodTesterTestClass::class,
            'instanceMethod',
            $method,
            $invoker,
            $instance,
            false,
            $passes,
            $failures,
            $skips,
            $warnings
        );

        $this->assertCount(2, $passes);
        $this->assertSame(MethodTesterTestClass::class . '->instanceMethod() [scenario1]', $passes[0]->identifier);
        $this->assertSame(MethodTesterTestClass::class . '->instanceMethod() [scenario2]', $passes[1]->identifier);
    }

    public function testTestInstanceMethodChecksExpectValueWhenScenarioHasExpect(): void
    {
        $passes = [];
        $failures = [];
        $skips = [];
        $warnings = [];
        $instance = new MethodTesterTestClass();
        $method = new ReflectionMethod(MethodTesterTestClass::class, 'instanceMethod');
        $invoker = fn () => 'result';
        $scenario = new Scenario('scenario1', [], 'expected value', 'default');

        $this->scenarioManager->allows('getScenarios')
            ->andReturn([$scenario]);

        $this->argumentResolver->allows('resolveScenarioArguments')
            ->andReturn([]);

        $this->instanceCreator->allows('createInstanceForFixture')
            ->andReturn($instance);

        $this->typeAsserter->allows('assertMatches');

        $this->expectAsserter->expects('assertExpect')
            ->once()
            ->with('result', 'expected value', MethodTesterTestClass::class . '->instanceMethod() [scenario1]');

        $this->methodTester->testInstanceMethod(
            MethodTesterTestClass::class,
            'instanceMethod',
            $method,
            $invoker,
            $instance,
            false,
            $passes,
            $failures,
            $skips,
            $warnings
        );
    }

    public function testTestInstanceMethodDoesNotCheckExpectValueWhenScenarioExpectIsTypeCheck(): void
    {
        $passes = [];
        $failures = [];
        $skips = [];
        $warnings = [];
        $instance = new MethodTesterTestClass();
        $method = new ReflectionMethod(MethodTesterTestClass::class, 'instanceMethod');
        $invoker = fn () => 'result';
        $scenario = new Scenario('scenario1', [], 'type check', 'default');

        $this->scenarioManager->allows('getScenarios')
            ->andReturn([$scenario]);

        $this->argumentResolver->allows('resolveScenarioArguments')
            ->andReturn([]);

        $this->instanceCreator->allows('createInstanceForFixture')
            ->andReturn($instance);

        $this->typeAsserter->allows('assertMatches');

        $this->expectAsserter->expects('assertExpect')
            ->never();

        $this->methodTester->testInstanceMethod(
            MethodTesterTestClass::class,
            'instanceMethod',
            $method,
            $invoker,
            $instance,
            false,
            $passes,
            $failures,
            $skips,
            $warnings
        );
    }

    public function testTestInstanceMethodCreatesInstanceForScenarioWhenInstanceScenarioSpecified(): void
    {
        $passes = [];
        $failures = [];
        $skips = [];
        $warnings = [];
        $instance = new MethodTesterTestClass();
        $scenarioInstance = new MethodTesterTestClass();
        $method = new ReflectionMethod(MethodTesterTestClass::class, 'instanceMethod');
        $invoker = fn () => 'result';
        $scenario = new Scenario('scenario1', [], 'type check', 'customInstance');

        $this->scenarioManager->allows('getScenarios')
            ->andReturn([$scenario]);

        $this->argumentResolver->allows('resolveScenarioArguments')
            ->andReturn([]);

        $this->instanceCreator->expects('createInstanceForFixture')
            ->once()
            ->with(MethodTesterTestClass::class, 'customInstance', \Mockery::on(function (&$autoGenerated) {
                $autoGenerated = false;
                return true;
            }))
            ->andReturn($scenarioInstance);

        $this->typeAsserter->allows('assertMatches');

        $this->methodTester->testInstanceMethod(
            MethodTesterTestClass::class,
            'instanceMethod',
            $method,
            $invoker,
            $instance,
            false,
            $passes,
            $failures,
            $skips,
            $warnings
        );
    }

    public function testTestInstanceMethodAddsFailResultWhenInstanceCreationFailsForScenario(): void
    {
        $passes = [];
        $failures = [];
        $skips = [];
        $warnings = [];
        $instance = new MethodTesterTestClass();
        $method = new ReflectionMethod(MethodTesterTestClass::class, 'instanceMethod');
        $invoker = fn () => 'result';
        $scenario = new Scenario('scenario1', [], instance: 'missingInstance');

        $this->scenarioManager->allows('getScenarios')
            ->andReturn([$scenario]);

        $this->argumentResolver->allows('resolveScenarioArguments')
            ->andReturn([]);

        $this->instanceCreator->allows('createInstanceForFixture')
            ->andReturn(null);

        $this->methodTester->testInstanceMethod(
            MethodTesterTestClass::class,
            'instanceMethod',
            $method,
            $invoker,
            $instance,
            false,
            $passes,
            $failures,
            $skips,
            $warnings
        );

        $this->assertCount(0, $passes);
        $this->assertCount(1, $failures);
        $this->assertInstanceOf(FailResult::class, $failures[0]);
        $this->assertStringContainsString('missingInstance', $failures[0]->message);
    }
}

class MethodTesterTestClass
{
    public function instanceMethod(): string
    {
        return 'result';
    }

    public static function staticMethod(): string
    {
        return 'static result';
    }
}

class MethodTesterTestClassWithPrivateConstructor
{
    private function __construct()
    {
    }

    public function instanceMethod(): string
    {
        return 'result';
    }
}
