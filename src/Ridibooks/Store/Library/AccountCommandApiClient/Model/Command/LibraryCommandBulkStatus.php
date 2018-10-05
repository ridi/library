<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Model\Command;

class LibraryCommandBulkStatus extends Command
{
    protected const REQUEST_METHOD = 'POST';
    protected const REQUEST_PATH = '/queue/bulk/status/';

    /** @var int[] */
    private $queue_ids;

    /**
     * @param int[] $queue_ids
     */
    public function __construct(array $queue_ids)
    {
        $this->queue_ids = $queue_ids;
    }

    /**
     * @return array
     */
    protected function serialize(): array
    {
        return ['queue_ids' => $this->queue_ids];
    }
}
