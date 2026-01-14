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

use InvalidArgumentException;
use PHPSure\Discovery\FileRequirer;
use PHPSure\Exception\InvalidPathException;
use PHPSure\Tests\AbstractTestCase;

/**
 * Class FileRequirerTest.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class FileRequirerTest extends AbstractTestCase
{
    private FileRequirer $fileRequirer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fileRequirer = new FileRequirer();
    }

    public function testRequireFilesThrowsExceptionForNonExistentPath(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Path "/non/existent/path" does not exist');

        $this->fileRequirer->requireFiles('/non/existent/path');
    }

    public function testRequireFilesReturnsSinglePhpFile(): void
    {
        $testFile = __DIR__ . '/../../Functional/Fixtures/MySimpleApp/User.php';

        $requiredFiles = $this->fileRequirer->requireFiles($testFile);

        static::assertArrayHasKey(realpath($testFile), $requiredFiles);
    }

    public function testRequireFilesRaisesExceptionOnNonPhpFile(): void
    {
        $nonPhpFile = dirname(__DIR__) . '/Fixtures/non_php_file.txt';

        $this->expectException(InvalidPathException::class);
        $this->expectExceptionMessage('File "' . $nonPhpFile . '" is not a PHP file');

        $this->fileRequirer->requireFiles($nonPhpFile);
    }
}
