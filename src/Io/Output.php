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
 * Class Output.
 *
 * Standard output implementation that writes to a stream resource.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
class Output implements OutputInterface
{
    /**
     * @param resource $stream The stream resource to write to.
     */
    public function __construct(
        private readonly mixed $stream
    ) {
    }

    /**
     * @inheritDoc
     */
    public function write(string $message): void
    {
        fwrite($this->stream, $message);
    }
}
