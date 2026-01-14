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

namespace PHPSure\Tests\Functional\Fixtures\MySimpleApp;

use PHPSure\Attributes\Fixture;

/**
 * Class User.
 *
 * Represents a user in the system.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class User
{
    public function __construct(
        private readonly int $id,
        private readonly string $name
    ) {
    }

    #[Fixture('default', args: [101, 'Dan'])]
    #[Fixture('admin', args: [1, 'Admin'])]
    public static function create(int $id, string $name): self
    {
        return new self($id, $name);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDisplayName(): string
    {
        return "User #{$this->id}: {$this->name}";
    }

    public function isAdmin(): bool
    {
        return $this->id === 1;
    }
}
