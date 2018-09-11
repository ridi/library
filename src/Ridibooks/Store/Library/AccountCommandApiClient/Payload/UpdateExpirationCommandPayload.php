<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Payload;

use Ridibooks\Store\Library\AccountCommandApiClient\Model\LibraryItemUpdateExpiration;

/**
 * @todo \Ridibooks\Store\Library\AccountCommandApiClient\Model\Command\LibraryUpdateExpirationCommand 로 이전
 */
class UpdateExpirationCommandPayload extends CommandPayload
{
    protected const REQUEST_METHOD = 'PUT';

    /** @var int */
    private $priority;

    /** @var LibraryItemUpdateExpiration[] */
    private $books;

    /**
     * @param int $u_idx
     * @param int $revision
     * @param int $priority
     * @param LibraryItemUpdateExpiration[] $books
     */
    public function __construct(int $u_idx, int $revision, int $priority, array $books)
    {
        parent::__construct($u_idx, $revision);
        $this->priority = $priority;
        $this->books = $books;
    }

    /**
     * @deprecated
     * @return string
     */
    public function getType(): string
    {
        return 'update';
    }

    /**
     * @return string
     */
    public function getRequestUri(): string
    {
        return '/commands/items/expiration/';
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $json = [
            'u_idx' => $this->getUidx(),
            'revision' => $this->getRevision(),
            'priority' => $this->priority,
            'books' => array_map(
                function (LibraryItemUpdateExpiration $book): array {
                    return $book->jsonSerialize();
                },
                $this->books
            )
        ];

        if ($this->getResponseFormat() !== null) {
            $json['response_format'] = $this->getResponseFormat();
        }

        return $json;
    }
}
