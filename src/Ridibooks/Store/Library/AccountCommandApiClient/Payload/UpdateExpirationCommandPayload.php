<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Payload;

use Ridibooks\Store\Library\AccountCommandApiClient\LibraryItemUpdateExpiration;

class UpdateExpirationCommandPayload extends CommandPayload
{
    private const METHOD = 'update';

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
        parent::__construct($u_idx, self::METHOD, $revision, $priority);
        $this->books = $books;
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
            'books' => array_map('json_encode', $this->books)
        ];

        if ($this->getResponseFormat() !== null) {
            $json['response_format'] = $this->getResponseFormat();
        }

        return $json;
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return 'PUT';
    }
}
