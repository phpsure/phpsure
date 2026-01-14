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

namespace PHPSure\Io;

/**
 * Class RecordingOutput.
 *
 * Output implementation that records all written messages for testing.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class RecordingOutput implements OutputInterface
{
    private string $output = '';

    /**
     * @inheritDoc
     */
    public function write(string $message): void
    {
        $this->output .= $message;
    }

    /**
     * Gets all output that has been written.
     *
     * @return string The recorded output.
     */
    public function getOutput(): string
    {
        return $this->output;
    }
}
