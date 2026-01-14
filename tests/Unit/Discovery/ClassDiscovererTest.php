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

use PHPSure\Discovery\ClassDiscoverer;
use PHPSure\Tests\AbstractTestCase;

/**
 * Class ClassDiscovererTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ClassDiscovererTest extends AbstractTestCase
{
    private ClassDiscoverer $classDiscoverer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->classDiscoverer = new ClassDiscoverer();
    }

    public function testDiscoverClassesReturnsEmptyArrayWhenNoFilesRequired(): void
    {
        $result = $this->classDiscoverer->discoverClasses([]);

        static::assertSame([], $result);
    }

    public function testDiscoverClassesFindsClassesFromRequiredFiles(): void
    {
        // Require a file with a class.
        require_once __DIR__ . '/../../Functional/Fixtures/MySimpleApp/User.php';

        $requiredFiles = [
            realpath(__DIR__ . '/../../Functional/Fixtures/MySimpleApp/User.php') => true,
        ];

        $result = $this->classDiscoverer->discoverClasses($requiredFiles);

        // Should find the class from the required file.
        static::assertArrayHasKey('phpsure\\tests\\functional\\fixtures\\mysimpleapp\\user', $result);
    }

    public function testDiscoverClassesStoresLowercaseKeyWithOriginalCaseValue(): void
    {
        // Require a file with a class.
        require_once __DIR__ . '/../../Functional/Fixtures/MySimpleApp/Money.php';

        $requiredFiles = [
            realpath(__DIR__ . '/../../Functional/Fixtures/MySimpleApp/Money.php') => true,
        ];

        $result = $this->classDiscoverer->discoverClasses($requiredFiles);

        // Key should be lowercase.
        static::assertArrayHasKey('phpsure\\tests\\functional\\fixtures\\mysimpleapp\\money', $result);
        // Value should be original case.
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\Money', $result['phpsure\\tests\\functional\\fixtures\\mysimpleapp\\money']);
    }

    public function testDiscoverClassesDoesNotIncludeClassesFromNonRequiredFiles(): void
    {
        $requiredFiles = [
            __FILE__ => true,
        ];

        $result = $this->classDiscoverer->discoverClasses($requiredFiles);

        // Should only include ClassDiscoverer and AbstractTestCase from this file.
        static::assertArrayHasKey('phpsure\\tests\\unit\\discovery\\classdiscoverertest', $result);
    }
}
