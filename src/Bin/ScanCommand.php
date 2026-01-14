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

use PHPSure\Exception\InvalidPathException;
use PHPSure\Io\OutputInterface;
use PHPSure\Runner\Result\TestResult;
use PHPSure\Runner\RunnerInterface;

/**
 * Class ScanCommand
 *
 * `phpsure` binary entrypoint.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class ScanCommand implements ScanCommandInterface
{
    public function __construct(
        private readonly RunnerInterface $runner,
        private readonly OutputInterface $stdout,
        private readonly OutputInterface $stderr
    ) {
    }

    /**
     * @inheritDoc
     */
    public function run(string $path, array $options): ?TestResult
    {
        if (!file_exists($path)) {
            $this->stderr->write('Error: Path "' . $path . '" does not exist' . PHP_EOL);

            return null;
        }

        try {
            // Run the scan.
            $result = $this->runner->run($path);
        } catch (InvalidPathException $exception) {
            $this->stderr->write($exception->getMessage() . PHP_EOL);

            return null;
        }

        // Print the summary.
        $this->stdout->write($result->getSummary());

        return $result;
    }
}
