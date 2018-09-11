<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Payload;

use Ridibooks\Store\Library\BasePayload;

/**
 * @todo \Ridibooks\Store\Library\AccountCommandApiClient\Model\Command\LibraryCommandBulkStatus 로 이전
 */
class BulkStatusPayload extends BasePayload
{
    protected const REQUEST_METHOD = 'POST';

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
}
