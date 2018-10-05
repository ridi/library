<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Model\Command;

use Ridibooks\Store\Library\AccountCommandApiClient\Model\LibraryItemFull;

class LibraryUpdateCommand extends UserCommand
{
    protected const REQUEST_METHOD = 'PUT';

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
     * @return array
     */
    protected function serialize(): array
    {
        return ['books' => $this->serializeItems($this->books)];
    }
}
