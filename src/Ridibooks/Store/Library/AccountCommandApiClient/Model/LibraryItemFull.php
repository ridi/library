<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Model;

use Ridibooks\Store\Library\AccountCommandApiClient\LibraryItem;

class LibraryItemFull implements \JsonSerializable
{
    /** @var string */
    private $b_id;

    /** @var string */
    private $service_type;

    /** @var \DateTime */
    private $expire_date;

    /** @var \DateTime */
    private $purchase_date;

    /** @var bool */
    private $is_canceled;

    /** @var bool */
    private $is_user_deleted;

    /** @var bool */
    private $is_deleted;

    /**
     * @param string $b_id
     * @param string $service_type
     * @param \DateTime $expire_date
     * @param \DateTime $purchase_date
     * @param bool $is_canceled
     * @param bool $is_user_deleted
     * @param bool $is_deleted
     */
    public function __construct(
        string $b_id,
        string $service_type,
        \DateTime $expire_date,
        \DateTime $purchase_date,
        bool $is_canceled,
        bool $is_user_deleted,
        bool $is_deleted
    ) {
        $timezone = new \DateTimeZone('Asia/Seoul');
        $this->b_id = $b_id;
        $this->service_type = $service_type;
        $this->expire_date = $expire_date->setTimezone($timezone);
        $this->purchase_date = $purchase_date->setTimezone($timezone);
        $this->is_canceled = $is_canceled;
        $this->is_user_deleted = $is_user_deleted;
        $this->is_deleted = $is_deleted;
    }

    /**
     * @param LibraryItem $library_item
     * @return self
     */
    public static function createFromLibraryItem(LibraryItem $library_item): self
    {
        return new self(
            $library_item->getBid(),
            $library_item->getServiceType(),
            $library_item->getExpireDate(),
            $library_item->getRegDate(),
            $library_item->isCanceled(),
            $library_item->isDeletedByUser(),
            $library_item->isDeleted()
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'b_id' => $this->b_id,
            'service_type' => $this->service_type,
            'expire_date' => $this->expire_date->format(DATE_ATOM),
            'purchase_date' => $this->purchase_date->format(DATE_ATOM),
            'is_canceled' => $this->is_canceled,
            'is_user_deleted' => $this->is_user_deleted,
            'is_deleted' => $this->is_deleted
        ];
    }
}
