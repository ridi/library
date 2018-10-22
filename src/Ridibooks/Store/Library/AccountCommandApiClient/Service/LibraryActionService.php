<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Service;

use Ridibooks\Store\Library\AccountCommandApiClient\Constant\CommandTypeConstant;
use Ridibooks\Store\Library\AccountCommandApiClient\Exception\LibraryItemCountException;
use Ridibooks\Store\Library\AccountCommandApiClient\Exception\LibraryItemFetchingException;
use Ridibooks\Store\Library\AccountCommandApiClient\Exception\UndefinedTypeException;
use Ridibooks\Store\Library\AccountCommandApiClient\LibraryAction;
use Ridibooks\Store\Library\AccountCommandApiClient\LibraryItem;
use Ridibooks\Store\Library\AccountCommandApiClient\Model\Command\LibraryDeleteCommand;
use Ridibooks\Store\Library\AccountCommandApiClient\Model\Command\LibraryUpdateCommand;
use Ridibooks\Store\Library\AccountCommandApiClient\Model\Command\LibraryUpdateExpirationCommand;
use Ridibooks\Store\Library\AccountCommandApiClient\Model\Command\UserCommand;
use Ridibooks\Store\Library\AccountCommandApiClient\Model\LibraryItemFull;
use Ridibooks\Store\Library\AccountCommandApiClient\Model\LibraryItemUpdateExpiration;

class LibraryActionService
{
    /**
     * @param LibraryAction $library_action
     * @return UserCommand
     * @throws LibraryItemCountException
     * @throws LibraryItemFetchingException
     * @throws UndefinedTypeException
     */
    public static function createCommand(LibraryAction $library_action): UserCommand
    {
        $u_idx = $library_action->getUidx();
        $revision_id = $library_action->getRevisionId();
        $priority = $library_action->getPriority();
        $b_ids = $library_action->getBids();
        $type = $library_action->getType();

        switch ($type) {
            case CommandTypeConstant::INSERT:
            case CommandTypeConstant::UPDATE:
                $library_items = array_map(
                    [LibraryItemFull::class, 'createFromLibraryItem'],
                    self::fetchLibraryItems($library_action)
                );

                return new LibraryUpdateCommand($u_idx, $revision_id, $priority, $library_items);

            case CommandTypeConstant::UPDATE_EXPIRATION:
                $library_items = array_map(
                    [LibraryItemUpdateExpiration::class, 'createFromLibraryItem'],
                    self::fetchLibraryItems($library_action)
                );

                return new LibraryUpdateExpirationCommand($u_idx, $revision_id, $priority, $library_items);

            case CommandTypeConstant::DELETE:
                return new LibraryDeleteCommand($u_idx, $revision_id, $priority, $b_ids);

            default:
                throw new UndefinedTypeException("$type is undefined type");
        }
    }

    /**
     * @param LibraryAction $library_action
     * @return LibraryItem[]
     * @throws LibraryItemCountException
     * @throws LibraryItemFetchingException
     */
    private static function fetchLibraryItems(LibraryAction $library_action): array
    {
        try {
            $related_library_items = $library_action->fetchRelatedLibraryItems();
        } catch (\Exception $e) {
            throw new LibraryItemFetchingException(
                'Exception occurred while fetching library items. ' . $e->getMessage(),
                0,
                $e
            );
        }

        $representative_library_items = array_map(
            [self::class, 'getRepresentativeLibraryItem'],
            array_values(self::groupLibraryItemsByBid($related_library_items))
        );

        $b_ids = $library_action->getBids();
        if (count($representative_library_items) !== count($b_ids)) {
            throw new LibraryItemCountException($b_ids, $representative_library_items);
        }

        return $representative_library_items;
    }

    /**
     * @param LibraryItem[] $library_items
     * @return array[]
     */
    private static function groupLibraryItemsByBid(array $library_items): array
    {
        $map = [];
        foreach ($library_items as $library_item) {
            $b_id = $library_item->getBid();
            if (isset($map[$b_id])) {
                $map[$b_id][] = $library_item;
            } else {
                $map[$b_id] = [$library_item];
            }
        }
        return $map;
    }

    /**
     * @param LibraryItem[] $library_items
     * @return LibraryItem having max id if there is no readable library_item
     *                     having max expiration among readable library_item, otherwise
     */
    private static function getRepresentativeLibraryItem(array $library_items): LibraryItem
    {
        /**
         * @var LibraryItem[] $readable_library_items
         */
        $readable_library_items = array_values(
            array_filter(
                $library_items,
                function (LibraryItem $library_item): bool {
                    return !$library_item->isCanceled() && !$library_item->isDeleted();
                }
            )
        );

        if (empty($readable_library_items)) {
            $representative_library_item = $library_items[0];

            foreach (array_slice($library_items, 1) as $library_item) {
                if ($library_item->getId() > $representative_library_item->getId()) {
                    $representative_library_item = $library_item;
                }
            }
        } else {
            $representative_library_item = $readable_library_items[0];

            foreach (array_slice($readable_library_items, 1) as $library_item) {
                $id = $library_item->getId();
                $expiration = $library_item->getExpireDate();
                $max_expiration = $representative_library_item->getExpireDate();
                $id_of_max_expiration = $representative_library_item->getId();

                if ($expiration > $max_expiration || ($expiration === $max_expiration && $id > $id_of_max_expiration)) {
                    $representative_library_item = $library_item;
                }
            }
        }

        return $representative_library_item;
    }
}
