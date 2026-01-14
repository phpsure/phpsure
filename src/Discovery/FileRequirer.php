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

use FilesystemIterator;
use InvalidArgumentException;
use PHPSure\Exception\InvalidPathException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Class FileRequirer.
 *
 * Requires PHP files from a directory or single file.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class FileRequirer implements FileRequirerInterface
{
    /**
     * @inheritDoc
     */
    public function requireFiles(string $path): array
    {
        /** @var array<string, true> $requiredFiles */
        $requiredFiles = [];

        if (is_file($path)) {
            // Single file.
            $realPath = realpath($path);

            if (pathinfo($realPath, PATHINFO_EXTENSION) !== 'php') {
                throw new InvalidPathException(
                    sprintf('File "%s" is not a PHP file', $realPath)
                );
            }

            if ($realPath !== false) {
                require_once $path;

                $requiredFiles[$realPath] = true;
            }

            return $requiredFiles;
        }

        if (!is_dir($path)) {
            throw new InvalidArgumentException(
                sprintf('Path "%s" does not exist', $path)
            );
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $filePath = $file->getPathname();
                $realPath = realpath($filePath);

                if ($realPath !== false) {
                    require_once $filePath;

                    $requiredFiles[$realPath] = true;
                }
            }
        }

        return $requiredFiles;
    }
}
