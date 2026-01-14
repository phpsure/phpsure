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

namespace PHPSure\Tests\Unit\Discovery;

use Mockery\MockInterface;
use PHPSure\Discovery\ClassDiscovererInterface;
use PHPSure\Discovery\DiscoveryResultInterface;
use PHPSure\Discovery\FileRequirerInterface;
use PHPSure\Discovery\FunctionDiscovererInterface;
use PHPSure\Discovery\Scanner;
use PHPSure\Tests\AbstractTestCase;
use PHPSure\Tests\Unit\Fixtures\ScannerTestAbstractFixtureClass;
use PHPSure\Tests\Unit\Fixtures\ScannerTestFixtureClass;
use ReflectionException;

/**
 * Class ScannerTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ScannerTest extends AbstractTestCase
{
    private MockInterface&ClassDiscovererInterface $classDiscoverer;
    private MockInterface&FileRequirerInterface $fileRequirer;
    private MockInterface&FunctionDiscovererInterface $functionDiscoverer;
    private Scanner $scanner;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fileRequirer = mock(FileRequirerInterface::class);
        $this->functionDiscoverer = mock(FunctionDiscovererInterface::class);
        $this->classDiscoverer = mock(ClassDiscovererInterface::class);

        $this->scanner = new Scanner(
            $this->fileRequirer,
            $this->functionDiscoverer,
            $this->classDiscoverer
        );
    }

    public function testScanRequiresFilesFromGivenPath(): void
    {
        $path = '/some/test/path';
        $requiredFiles = ['/some/test/path/file.php' => true];

        $this->fileRequirer->expects('requireFiles')
            ->once()
            ->with($path)
            ->andReturn($requiredFiles);
        $this->functionDiscoverer->expects('discoverFunctions')
            ->once()
            ->with($requiredFiles)
            ->andReturn([]);
        $this->classDiscoverer->expects('discoverClasses')
            ->once()
            ->with($requiredFiles)
            ->andReturn([]);

        $this->scanner->scan($path);
    }

    public function testScanReturnsDiscoveryResultWithDiscoveredFunctions(): void
    {
        $path = '/some/test/path';
        $requiredFiles = ['/some/test/path/file.php' => true];
        $discoveredFunctions = ['myfunc' => 'myFunc'];

        $this->fileRequirer->allows('requireFiles')
            ->andReturn($requiredFiles);
        $this->functionDiscoverer->allows('discoverFunctions')
            ->with($requiredFiles)
            ->andReturn($discoveredFunctions);
        $this->classDiscoverer->allows('discoverClasses')
            ->with($requiredFiles)
            ->andReturn([]);

        $result = $this->scanner->scan($path);

        static::assertInstanceOf(DiscoveryResultInterface::class, $result);
        static::assertSame($discoveredFunctions, $result->getFunctionNames());
    }

    public function testScanReturnsDiscoveryResultWithDiscoveredClasses(): void
    {
        $path = '/some/test/path';
        $requiredFiles = ['/some/test/path/file.php' => true];
        $discoveredClasses = ['myclass' => 'MyClass'];

        $this->fileRequirer->allows('requireFiles')
            ->andReturn($requiredFiles);
        $this->functionDiscoverer->allows('discoverFunctions')
            ->with($requiredFiles)
            ->andReturn([]);
        $this->classDiscoverer->allows('discoverClasses')
            ->with($requiredFiles)
            ->andReturn($discoveredClasses);

        $result = $this->scanner->scan($path);

        static::assertInstanceOf(DiscoveryResultInterface::class, $result);
        static::assertSame($discoveredClasses, $result->getClassNames());
    }

    public function testScanReturnsDiscoveryResultWithBothFunctionsAndClasses(): void
    {
        $path = '/some/test/path';
        $requiredFiles = ['/some/test/path/file.php' => true];
        $discoveredFunctions = ['myfunc' => 'myFunc'];
        $discoveredClasses = ['myclass' => 'MyClass'];

        $this->fileRequirer->allows('requireFiles')
            ->andReturn($requiredFiles);
        $this->functionDiscoverer->allows('discoverFunctions')
            ->with($requiredFiles)
            ->andReturn($discoveredFunctions);
        $this->classDiscoverer->allows('discoverClasses')
            ->with($requiredFiles)
            ->andReturn($discoveredClasses);

        $result = $this->scanner->scan($path);

        static::assertInstanceOf(DiscoveryResultInterface::class, $result);
        static::assertSame($discoveredFunctions, $result->getFunctionNames());
        static::assertSame($discoveredClasses, $result->getClassNames());
    }

    public function testGetInstanceMethodsReturnsPublicInstanceMethods(): void
    {
        $methods = $this->scanner->getInstanceMethods(ScannerTestFixtureClass::class);

        static::assertArrayHasKey('publicInstanceMethod', $methods);
        static::assertCount(1, $methods);
    }

    public function testGetInstanceMethodsExcludesConstructor(): void
    {
        $methods = $this->scanner->getInstanceMethods(ScannerTestFixtureClass::class);

        static::assertArrayNotHasKey('__construct', $methods);
    }

    public function testGetInstanceMethodsExcludesStaticMethods(): void
    {
        $methods = $this->scanner->getInstanceMethods(ScannerTestFixtureClass::class);

        static::assertArrayNotHasKey('publicStaticMethod', $methods);
    }

    public function testGetInstanceMethodsExcludesAbstractMethods(): void
    {
        $methods = $this->scanner->getInstanceMethods(ScannerTestAbstractFixtureClass::class);

        static::assertArrayNotHasKey('abstractMethod', $methods);
    }

    public function testGetInstanceMethodsThrowsExceptionForNonExistentClass(): void
    {
        $this->expectException(ReflectionException::class);

        $this->scanner->getInstanceMethods('NonExistentClass');
    }

    public function testGetStaticMethodsReturnsPublicStaticMethods(): void
    {
        $methods = $this->scanner->getStaticMethods(ScannerTestFixtureClass::class);

        static::assertArrayHasKey('publicStaticMethod', $methods);
        static::assertCount(1, $methods);
    }

    public function testGetStaticMethodsExcludesConstructor(): void
    {
        $methods = $this->scanner->getStaticMethods(ScannerTestFixtureClass::class);

        static::assertArrayNotHasKey('__construct', $methods);
    }

    public function testGetStaticMethodsExcludesInstanceMethods(): void
    {
        $methods = $this->scanner->getStaticMethods(ScannerTestFixtureClass::class);

        static::assertArrayNotHasKey('publicInstanceMethod', $methods);
    }

    public function testGetStaticMethodsExcludesAbstractMethods(): void
    {
        $methods = $this->scanner->getStaticMethods(ScannerTestAbstractFixtureClass::class);

        static::assertArrayNotHasKey('abstractStaticMethod', $methods);
    }

    public function testGetStaticMethodsThrowsExceptionForNonExistentClass(): void
    {
        $this->expectException(ReflectionException::class);

        $this->scanner->getStaticMethods('NonExistentClass');
    }
}
