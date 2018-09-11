<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Service;

class RevisionService
{
    /**
     * @param \DateTime|null $action_time
     * @return int
     */
    public static function generate(?\DateTime $action_time = null): int
    {
        if ($action_time === null) {
            $action_time = new \DateTime();
        }

        return $action_time->getTimestamp() * 1000 + (int)$action_time->format('v');
    }
}
