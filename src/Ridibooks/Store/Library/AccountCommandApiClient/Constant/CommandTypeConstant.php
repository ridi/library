<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Constant;

class CommandTypeConstant
{
    public const INSERT = 'INSERT';
    public const UPDATE = 'UPDATE';
    public const UPDATE_EXPIRATION = 'UPDATE_EXPIRATION';
    public const DELETE = 'DELETE';

    public const AVAILABLE = [
        self::INSERT,
        self::UPDATE,
        self::UPDATE_EXPIRATION,
        self::DELETE
    ];
}
