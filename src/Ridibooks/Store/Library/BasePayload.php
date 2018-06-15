<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library;

/*
 * 모든 payload는 이 클래스를 상속받는다.
 */
abstract class BasePayload implements \JsonSerializable
{
    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
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
