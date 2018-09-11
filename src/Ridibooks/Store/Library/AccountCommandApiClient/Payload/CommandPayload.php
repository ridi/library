<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Payload;

use Ridibooks\Store\Library\BasePayload;

/**
 * @todo CommandPayload 라는 용어를 제거하고 Command로 변경
 * @todo \Ridibooks\Store\Library\AccountCommandApiClient\Model\Command\Command 로 이전
 */
abstract class CommandPayload extends BasePayload
{
    private const RESPONSE_FORMAT_BIDS = 'b_ids';

    /** @var int */
    private $u_idx;
    /** @var int */
    private $revision;
    /** @var int|null */
    private $priority;
    /** @var string|null */
    private $response_format;

    /**
     * @param int $u_idx
     * @param int $revision
     * @param int|null $priority
     */
    public function __construct(int $u_idx, int $revision, ?int $priority = null)
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
     * @return int|null
     */
    public function getPriority(): ?int
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
