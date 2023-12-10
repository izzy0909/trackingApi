<?php declare(strict_types = 1);

namespace App\Traits;

use Psr\Log\LoggerInterface;

/**
 * Class LoggerAwareTrait
 */
trait LoggerAwareTrait
{
    protected LoggerInterface $logger;

    /**
     * Sets a logger.
     *
     * @required
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger) : void
    {
        $this->logger = $logger;
    }
}
