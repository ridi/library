<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Payload;

class BulkStatusPayload implements \JsonSerializable
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
        $json = [
            'queue_ids' => $this->getQueueIds()
        ];
        
        return $json;
    }

    /**
     * @return string
     */
    public function getRequestUri(): string
    {
        return "/commands/items/queue/bulk/status";
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return 'POST';
    }
}
