<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Constant;

/*
 * 범위: 0 ~ 255
 * 사용처가 있는 값만 정의한다.
 *
 * 0            - HIGHEST
 * 1 ~ 127      - HIGHxx
 * 128          - DEFAULT
 * 129 ~ 254    - LOWxx
 * 255          - LOWEST
 */
class JobPriorityConstant
{
    public const LOWEST = 255;

    public const LOW192 = 192;

    public const DEFAULT = 128;

    public const HIGH64 = 64;
}
