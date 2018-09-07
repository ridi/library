<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Payload;

use Ridibooks\Store\Library\BasePayload;

abstract class CommandPayload extends BasePayload
{
    private const RESPONSE_FORMAT_BIDS = 'b_ids';

    /** @var int */
    private $u_idx;
    /** @var int */
    private $revision;
    /** @var int */
    private $priority;
    /** @var string|null */
    private $response_format;

    /**
     * @param int $u_idx
     * @param int $revision
     * @param int $priority
     */
    public function __construct(int $u_idx, int $revision, int $priority)
    {
        $this->u_idx = $u_idx;
        $this->revision = $revision;
        $this->priority = $priority;
        $this->response_format = null;
    }

    public function setResponseTypeBids()
    {
        $this->response_format = self::RESPONSE_FORMAT_BIDS;
    }

    /**
     * @return string
     */
    public function getRequestUri(): string
    {
        return '/commands/items/';
    }

    /**
     * @return int
     */
    public function getUidx(): int
    {
        return $this->u_idx;
    }

    /**
     * @return int
     */
    public function getRevision(): int
    {
        return $this->revision;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return string|null
     */
    public function getResponseFormat(): ?string
    {
        return $this->response_format;
    }
}
