<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient;

interface LibraryItem
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getBid(): string;

    /**
     * @return string
     */
    public function getServiceType(): string;

    /**
     * @return \DateTime
     */
    public function getExpireDate(): \DateTime;

    /**
     * @return \DateTime
     */
    public function getRegDate(): \DateTime;

    /**
     * @return bool
     */
    public function isCanceled(): bool;

    /**
     * @return bool
     */
    public function isDeleted(): bool;

    /**
     * @return bool
     */
    public function isDeletedByUser(): bool;

    /**
     * @return bool
     */
    public function isRidiSelectBook(): bool;
}
