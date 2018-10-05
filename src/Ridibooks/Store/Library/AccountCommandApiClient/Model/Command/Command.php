<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient\Model\Command;

abstract class Command implements \JsonSerializable
{
    protected const REQUEST_METHOD = 'GET';
    protected const REQUEST_PATH = '/';

    /**
     * @return array
     */
    abstract protected function serialize(): array;

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->serialize();
    }

    /**
     * @return string
     */
    final public function getRequestUri(): string
    {
        return '/commands/items' . static::REQUEST_PATH;
    }

    /**
     * @return string
     */
    final public function getRequestMethod(): string
    {
        return static::REQUEST_METHOD;
    }
}
