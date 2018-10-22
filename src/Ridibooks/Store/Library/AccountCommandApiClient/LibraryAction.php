<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient;

interface LibraryAction
{
    /**
     * @return int
     */
    public function getRevisionId(): int;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return int
     */
    public function getPriority(): int;

    /**
     * @return int
     */
    public function getUidx(): int;

    /**
     * @return string[]
     */
    public function getBids(): array;

    /**
     * fetch all library items matching u_idx and b_ids
     * @return LibraryItem[]
     */
    public function fetchRelatedLibraryItems(): array;
}
