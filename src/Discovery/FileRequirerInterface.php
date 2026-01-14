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

namespace PHPSure\Discovery;

use PHPSure\Exception\InvalidPathException;

/**
 * Interface FileRequirerInterface.
 *
 * Requires PHP files from a directory or single file.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface FileRequirerInterface
{
    /**
     * Requires all PHP files in the given directory or a single file.
     *
     * @param string $path The directory or file to require files from.
     * @return array<string, true> Map of file paths required.
     * @throws InvalidPathException When the given path is not a directory or a PHP file.
     */
    public function requireFiles(string $path): array;
}
