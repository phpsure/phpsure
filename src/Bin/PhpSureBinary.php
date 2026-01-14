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

namespace PHPSure\Bin;

use PHPSure\Io\OutputInterface;

/**
 * Class PhpSureBinary.
 *
 * `phpsure` binary entrypoint.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class PhpSureBinary implements PhpSureBinaryInterface
{
    public function __construct(
        private readonly ScanCommandInterface $scanCommand,
        private readonly OutputInterface $stderr
    ) {
    }

    /**
     * Runs the binary with the given CLI arguments.
     *
     * @param string[] $argv CLI arguments.
     * @return int Exit code.
     */
    public function run(array $argv): int
    {
        $argc = count($argv);

        if ($argc < 2) {
            return $this->printUsage();
        }

        $command = $argv[1];

        if ($command !== 'scan') {
            $this->stderr->write('Error: Unknown command "' . $command . '"' . PHP_EOL . PHP_EOL);

            return $this->printUsage();
        }

        if ($argc < 3) {
            $this->stderr->write('Error: Path argument is required for "scan" command' . PHP_EOL . PHP_EOL);

            return $this->printUsage();
        }

        $path = $argv[2];

        $result = $this->scanCommand->run($path, []);

        if ($result === null) {
            return 1; // Configuration error or similar.
        }

        // Exit with non-zero code if there were scan failures.
        return $result->hasFailures() ? 3 : 0;
    }

    private function printUsage(): int
    {
        $this->stderr->write('Usage: phpsure scan <directory-or-file>' . PHP_EOL);
        $this->stderr->write('  scan    Scan the given directory or file and run contract checks' . PHP_EOL);

        return 1;
    }
}
