<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Constant;

class JobStatusConstant
{
    public const WAITING = 'WAITING';
    public const ONGOING = 'ONGOING';
    public const DONE = 'DONE';
    public const FAILED = 'FAILED';

    public const AVAILABLE = [
        self::WAITING,
        self::ONGOING,
        self::DONE,
        self::FAILED
    ];
}
