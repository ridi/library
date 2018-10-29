<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Model;

use Ridibooks\Store\Library\AccountCommandApiClient\LibraryItem;

class LibraryItemUpdateExpiration implements \JsonSerializable
{
    /** @var string */
    private $b_id;

    /** @var bool */
    private $by_user;

    /** @var string */
    private $service_type;

    /** @var \DateTime */
    private $expiration_date;

    /**
     * @param string $b_id
     * @param bool $by_user
     * @param string $service_type
     * @param \DateTime $expiration_date
     */
    public function __construct(string $b_id, bool $by_user, string $service_type, \DateTime $expiration_date)
    {
        $this->b_id = $b_id;
        $this->by_user = $by_user;
        $this->service_type = $service_type;
        $this->expiration_date = $expiration_date->setTimezone(new \DateTimeZone('Asia/Seoul'));
    }

    /**
     * @param LibraryItem $library_item
     * @return self
     */
    public static function createFromLibraryItem(LibraryItem $library_item): self
    {
        $is_expiration_update_by_user = !$library_item->isRidiSelectBook();

        return new self(
            $library_item->getBid(),
            $is_expiration_update_by_user,
            $library_item->getServiceType(),
            $library_item->getExpireDate()
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'b_id' => $this->b_id,
            'by_user' => $this->by_user,
            'service_type' => $this->service_type,
            'expire_date' => $this->expiration_date->format(DATE_ATOM)
        ];
    }
}
