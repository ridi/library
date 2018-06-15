<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Payload;

class DeleteCommandPayload extends BaseCommandPayload
{
    private const METHOD = 'delete';

    /** @var string[] */
    private $b_ids;

    /**
     * DeleteCommandPayload constructor.
     * @param int $u_idx
     * @param int $revision
     * @param int $priority
     * @param string[] $b_ids
     */
    public function __construct(int $u_idx, int $revision, int $priority, array $b_ids)
    {
        parent::__construct($u_idx, self::METHOD, $revision, $priority);
        $this->b_ids = $b_ids;
    }

    /**
     * @return string[]
     */
    public function getBIds(): array
    {
        return $this->b_ids;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize(): array
    {
        $json = [
            'u_idx' => $this->getUidx(),
            'revision' => $this->getRevision(),
            'priority' => $this->getPriority(),
            'b_ids' => $this->getBIds()
        ];
        if (!is_null($this->getResponseType())) {
            $json['response_type'] = $this->getResponseType();
        }
        return $json;
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return 'DELETE';
    }
}
