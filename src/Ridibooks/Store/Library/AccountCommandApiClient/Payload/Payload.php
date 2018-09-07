<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Payload;

/*
 * 모든 payload는 이 클래스를 상속받아야만 함
 */
abstract class Payload implements \JsonSerializable
{
    protected const REQUEST_METHOD = 'GET';

    /**
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return array
     */
    abstract public function jsonSerialize(): array;

    /**
     * @return string
     */
    abstract public function getRequestUri(): string;

    /**
     * @return string
     */
    final public function getRequestMethod(): string
    {
        return static::REQUEST_METHOD;
    }
}
