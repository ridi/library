<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Payload;

use Ridibooks\Store\Library\BasePayload;

class BulkStatusPayload extends BasePayload
{
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
     * @deprecated
     * @return int[]
     */
    public function getQueueIds(): array
    {
        return $this->queue_ids;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return ['queue_ids' => $this->queue_ids];
    }

    /**
     * @return string
     */
    public function getRequestUri(): string
    {
        return '/commands/items/queue/bulk/status';
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return 'POST';
    }
}
