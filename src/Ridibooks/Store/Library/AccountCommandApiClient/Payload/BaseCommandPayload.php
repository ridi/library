<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Payload;

abstract class BaseCommandPayload implements \JsonSerializable
{
    /** @var int */
    private $u_idx;
    /** @var string */
    private $type;
    /** @var int */
    private $revision;
    /** @var int */
    private $priority;

    /**
     * @param int $u_idx
     * @param string $type
     * @param int $revision
     * @param int $priority
     */
    public function __construct(int $u_idx, string $type, int $revision, int $priority)
    {
        $this->u_idx = $u_idx;
        $this->type = $type;
        $this->revision = $revision;
        $this->priority = $priority;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    abstract public function jsonSerialize(): array;

    /**
     * @return string
     */
    public function getRequestUri(): string
    {
        return "/items/{$this->type}/{$this->u_idx}/";
    }

    /**
     * @return int
     */
    public function getUidx(): int
    {
        return $this->u_idx;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
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
}