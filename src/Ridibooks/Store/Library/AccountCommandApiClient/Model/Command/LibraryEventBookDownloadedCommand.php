<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Model\Command;

use Ridibooks\Store\Library\AccountCommandApiClient\Payload\CommandPayload;

class LibraryEventBookDownloadedCommand extends CommandPayload
{
    protected const REQUEST_METHOD = 'PUT';

    /** @var int|null */
    private $priority;

    /** @var string[] */
    private $b_ids;

    /**
     * @param int $u_idx
     * @param int $revision
     * @param array $b_ids
     * @param int|null $priority
     */
    public function __construct(int $u_idx, int $revision, array $b_ids, ?int $priority = null)
    {
        parent::__construct($u_idx, $revision);
        $this->priority = $priority;
        $this->b_ids = $b_ids;
    }

    /**
     * @return string
     */
    public function getRequestUri(): string
    {
        return '/commands/items/events/book-downloaded/';
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'u_idx' => $this->getUidx(),
            'revision' => $this->getRevision(),
            'b_ids' => $this->b_ids
        ];

        if ($this->priority !== null) {
            $json['priority'] = $this->priority;
        }

        if ($this->getResponseFormat() !== null) {
            $json['response_format'] = $this->getResponseFormat();
        }

        return $json;
    }
}
