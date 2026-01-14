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
 * Interface OutputInterface.
 *
 * Abstraction for output streams.
 *
 * @author Dan Phillimore <dan@ovms.co>
 */
interface OutputInterface
{
    /**
     * Writes a message to the output stream.
     *
     * @param string $message The message to write.
     */
    public function write(string $message): void;
}
