<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Payload;

use Ridibooks\Store\Library\AccountCommandApiClient\Book;

class UpdateCommandPayload implements \JsonSerializable
{
    /** @var int */
    private $u_idx;
    /** @var string */
    private $type;
    /** @var int */
    private $revision;
    /** @var int */
    private $priority;
    /** @var Book[] */
    private $books;

    /**
     * @param int $u_idx
     * @param string $type
     * @param int $revision
     * @param int $priority
     * @param Book[] $books
     */
    public function __construct(int $u_idx, string $type, int $revision, int $priority, array $books)
    {
        $this->u_idx = $u_idx;
        $this->type = $type;
        $this->revision = $revision;
        $this->priority = $priority;
        $this->books = $books;
    }

    /**
     * @return int
     */
    public function getUidx(): int
    {
        return $this->u_idx;
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
            'u_idx' => $this->u_idx,
            'type' => $this->type,
            'revision' => $this->revision,
            'priority' => $this->priority,
            'books' => []
        ];
        foreach ($this->books as $book) {
            $json['books'][] = $book->jsonSerialize();
        }
        return $json;
    }
}
