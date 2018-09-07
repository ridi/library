<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Payload;

class DeleteCommandPayload extends CommandPayload
{
    protected const REQUEST_METHOD = 'DELETE';

    /** @var string[] */
    private $b_ids;

    /**
     * @param int $u_idx
     * @param int $revision
     * @param int $priority
     * @param string[] $b_ids
     */
    public function __construct(int $u_idx, int $revision, int $priority, array $b_ids)
    {
        parent::__construct($u_idx, $revision, $priority);
        $this->b_ids = $b_ids;
    }

    /**
     * @deprecated
     * @return string
     */
    public function getType(): string
    {
        return 'delete';
    }

    /**
     * @return string[]
     */
    public function getBIds(): array
    {
        return $this->b_ids;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'u_idx' => $this->getUidx(),
            'revision' => $this->getRevision(),
            'priority' => $this->getPriority(),
            'b_ids' => $this->getBIds()
        ];
        if (!is_null($this->getResponseFormat())) {
            $json['response_formant'] = $this->getResponseFormat();
        }
        return $json;
    }
}
