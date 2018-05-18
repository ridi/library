<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Payload;

use Ridibooks\Store\Library\AccountCommandApiClient\Book;

class UpdateCommandPayload extends BaseCommandPayload
{
    public const METHOD = 'update';

    /**
     * UpdateCommandPayload constructor.
     * @param int $u_idx
     * @param int $revision
     * @param int $priority
     * @param Book[] $books
     */
    public function __construct(int $u_idx, int $revision, int $priority, array $books)
    {
        parent::__construct($u_idx, self::METHOD, $revision, $priority, null, $books);
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
            'type' => $this->getType(),
            'revision' => $this->getRevision(),
            'priority' => $this->getPriority(),
            'books' => []
        ];
        foreach ($this->getBooks() as $book) {
            $json['books'][] = $book->jsonSerialize();
        }
        return $json;
    }
}
