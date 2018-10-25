<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Exception;

use Ridibooks\Store\Library\AccountCommandApiClient\Model\Command\Command;

class RequestException extends LibraryApiException
{
    /** @var Command|null */
    private $command;

    /** @var \Throwable */
    private $reason;

    public function __construct(\Throwable $reason, ?Command $command)
    {
        $this->reason = $reason;
        $this->command = $command;
        parent::__construct('Failed to send library api. ' . $reason->getMessage(), 0, $reason);
    }

    /**
     * @return Command|null null if failed to create command
     */
    public function getCommand(): ?Command
    {
        return $this->command;
    }

    /**
     * @return \Throwable
     */
    public function getReason(): \Throwable
    {
        return $this->reason;
    }
}
