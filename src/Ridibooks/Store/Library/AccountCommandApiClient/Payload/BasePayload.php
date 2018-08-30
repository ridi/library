<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Payload;

/*
 * 동일 namespace 내의 모든 payload는 이 클래스를 상속받아야만 함
 */
abstract class BasePayload implements \JsonSerializable
{
    /**
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return array
     */
    abstract public function jsonSerialize(): array;

    /**
     * @return string
     */
    abstract public function getRequestMethod(): string;

    /**
     * @return string
     */
    abstract public function getRequestUri(): string;
}
