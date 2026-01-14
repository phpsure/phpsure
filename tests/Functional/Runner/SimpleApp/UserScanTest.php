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

namespace PHPSure\Tests\Functional\Runner\SimpleApp;

use PHPSure\Implementation\Implementation;
use PHPSure\Runner\RunnerInterface;
use PHPSure\Tests\Functional\AbstractFunctionalTestCase;
use PHPSure\Tests\Functional\Fixtures\MySimpleApp\User;

/**
 * Class UserScanTest.
 *
 * Functional tests for scanning User.php.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class UserScanTest extends AbstractFunctionalTestCase
{
    private RunnerInterface $runner;

    public function setUp(): void
    {
        $this->runner = (new Implementation())->getRunner();
    }

    public function testUserCreateDefaultPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/User.php');

        $methodResult = $result->getMethodResult(User::class, 'create');
        $passes = $methodResult->getPasses();

        static::assertCount(2, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\User::create() [default]', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testUserCreateAdminPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/User.php');

        $methodResult = $result->getMethodResult(User::class, 'create');
        $passes = $methodResult->getPasses();

        static::assertCount(2, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\User::create() [admin]', $passes[1]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testUserGetIdPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/User.php');

        $methodResult = $result->getMethodResult(User::class, 'getId');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\User->getId()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testUserGetNamePasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/User.php');

        $methodResult = $result->getMethodResult(User::class, 'getName');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\User->getName()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testUserGetDisplayNamePasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/User.php');

        $methodResult = $result->getMethodResult(User::class, 'getDisplayName');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\User->getDisplayName()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }

    public function testUserIsAdminPasses(): void
    {
        $result = $this->runner->run(__DIR__ . '/../../Fixtures/MySimpleApp/User.php');

        $methodResult = $result->getMethodResult(User::class, 'isAdmin');
        $passes = $methodResult->getPasses();

        static::assertCount(1, $passes);
        static::assertEquals('PHPSure\\Tests\\Functional\\Fixtures\\MySimpleApp\\User->isAdmin()', $passes[0]->identifier);
        static::assertEmpty($methodResult->getFailures());
        static::assertEmpty($methodResult->getSkips());
    }
}
