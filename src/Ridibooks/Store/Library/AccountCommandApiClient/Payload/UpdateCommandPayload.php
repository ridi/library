<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Payload;

use Ridibooks\Store\Library\AccountCommandApiClient\Book;

class UpdateCommandPayload extends BaseCommandPayload
{
    private const METHOD = 'update';

    /** @var Book[] */
    private $books;

    /**
     * UpdateCommandPayload constructor.
     * @param int $u_idx
     * @param int $revision
     * @param int $priority
     * @param Book[] $books
     */
    public function __construct(int $u_idx, int $revision, int $priority, array $books)
    {
        parent::__construct($u_idx, self::METHOD, $revision, $priority);
        $this->books = $books;
    }

    /**
     * @return Book[]
     */
    public function getBooks(): array
    {
        return $this->books;
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
            'books' => []
        ];
        foreach ($this->getBooks() as $book) {
            $json['books'][] = $book->jsonSerialize();
        }
        if (!is_null($this->getResponseFormat())) {
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
