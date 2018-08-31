<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Payload;

use Ridibooks\Store\Library\AccountCommandApiClient\Model\LibraryItemFull;

class UpdateCommandPayload extends CommandPayload
{
    /** @var LibraryItemFull[] */
    private $books;

    /**
     * @param int $u_idx
     * @param int $revision
     * @param int $priority
     * @param LibraryItemFull[] $books
     */
    public function __construct(int $u_idx, int $revision, int $priority, array $books)
    {
        parent::__construct($u_idx, $revision, $priority);
        $this->books = $books;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'update';
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return 'PUT';
    }

    /**
     * @deprecated
     * @return LibraryItemFull[]
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
            'books' => array_map(
                function (LibraryItemFull $book): array {
                    return $book->jsonSerialize();
                },
                $this->getBooks()
            )
        ];

        if ($this->getResponseFormat() !== null) {
            $json['response_format'] = $this->getResponseFormat();
        }

        return $json;
    }
}
