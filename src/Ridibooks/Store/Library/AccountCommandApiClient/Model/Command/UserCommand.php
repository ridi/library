<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Model\Command;

abstract class UserCommand extends Command
{
    /** @var int */
    private $u_idx;
    /** @var int */
    private $revision;
    /** @var int */
    private $priority;
    /** @var bool */
    private $is_response_format_b_ids = false;

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
    }

    /**
     * @return UserCommand
     */
    final public function setResponseTypeBids(): self
    {
        $this->is_response_format_b_ids = true;
        return $this;
    }

    /**
     * @return array
     */
    final public function jsonSerialize(): array
    {
        $json = [
            'u_idx' => $this->u_idx,
            'revision' => $this->revision,
            'priority' => $this->priority
        ];
        if ($this->is_response_format_b_ids) {
            $json['response_format'] = 'b_ids';
        }

        return array_merge($json, $this->serialize());
    }

    /**
     * @param \JsonSerializable $item
     * @return array
     */
    final protected function serializeItem(\JsonSerializable $item): array
    {
        return $item->jsonSerialize();
    }

    /**
     * @param \JsonSerializable[] $items
     * @return array[]
     */
    final protected function serializeItems(array $items): array
    {
        return array_map([$this, 'serializeItem'], $items);
    }
}
