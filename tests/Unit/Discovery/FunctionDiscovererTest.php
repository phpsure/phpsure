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

use PHPSure\Discovery\FunctionDiscoverer;
use PHPSure\Tests\AbstractTestCase;

/**
 * Class FunctionDiscovererTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class FunctionDiscovererTest extends AbstractTestCase
{
    private FunctionDiscoverer $functionDiscoverer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->functionDiscoverer = new FunctionDiscoverer();
    }

    public function testDiscoverFunctionsReturnsEmptyArrayWhenNoFilesRequired(): void
    {
        $result = $this->functionDiscoverer->discoverFunctions([]);

        static::assertSame([], $result);
    }

    public function testDiscoverFunctionsReturnsEmptyArrayWhenNoFunctionsInRequiredFiles(): void
    {
        $requiredFiles = [
            __FILE__ => true,
        ];

        $result = $this->functionDiscoverer->discoverFunctions($requiredFiles);

        static::assertSame([], $result);
    }

    public function testDiscoverFunctionsFindsUserFunctionsFromRequiredFiles(): void
    {
        // Require a file with functions.
        require_once __DIR__ . '/../../Functional/Fixtures/MySimpleApp/functions.php';

        $requiredFiles = [
            realpath(__DIR__ . '/../../Functional/Fixtures/MySimpleApp/functions.php') => true,
        ];

        $result = $this->functionDiscoverer->discoverFunctions($requiredFiles);

        // Should find the functions from the required file.
        static::assertArrayHasKey('phpsure\\tests\\functional\\fixtures\\mysimpleapp\\double', $result);
    }

    public function testDiscoverFunctionsStoresLowercaseKeyWithOriginalCaseValue(): void
    {
        // Require a file with functions.
        require_once __DIR__ . '/../../Functional/Fixtures/MySimpleApp/functions.php';

        $requiredFiles = [
            realpath(__DIR__ . '/../../Functional/Fixtures/MySimpleApp/functions.php') => true,
        ];

        $result = $this->functionDiscoverer->discoverFunctions($requiredFiles);

        // Key should be lowercase.
        static::assertArrayHasKey('phpsure\\tests\\functional\\fixtures\\mysimpleapp\\double', $result);
        // Value should be correct case.
        static::assertSame('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\double', $result['phpsure\\tests\\functional\\fixtures\\mysimpleapp\\double']);
    }
}
