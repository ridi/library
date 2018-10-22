<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Exception;

use Ridibooks\Store\Library\AccountCommandApiClient\LibraryItem;

class LibraryItemCountException extends LibraryApiException implements \JsonSerializable
{
    /** @var string[] */
    private $b_ids;

    /** @var LibraryItem[] */
    private $library_items;

    /**
     * @param string[] $b_ids
     * @param LibraryItem[] $books
     */
    public function __construct(array $b_ids, array $books)
    {
        $this->b_ids = $b_ids;
        $this->library_items = $books;

        parent::__construct('The number of b_ids and the number of books are different');
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'b_ids_count' => count($this->b_ids),
            'books_count' => count($this->library_items),
            'b_ids' => $this->b_ids,
            'books' => array_map([self::class, 'serializeLibraryItem'], $this->library_items)
        ];
    }

    /**
     * @param LibraryItem $library_item
     * @return array
     */
    private static function serializeLibraryItem(LibraryItem $library_item): array
    {
        return [
            'id' => $library_item->getId(),
            'b_id' => $library_item->getBid(),
            'service_type' => $library_item->getServiceType(),
            'expire_date' => $library_item->getExpireDate(),
            'reg_date' => $library_item->getRegDate(),
            'is_canceled' => $library_item->isCanceled(),
            'is_deleted' => $library_item->isDeleted(),
            'is_deleted_by_user' => $library_item->isDeletedByUser(),
            'is_ridi_select_book' => $library_item->isRidiSelectBook()
        ];
    }
}
