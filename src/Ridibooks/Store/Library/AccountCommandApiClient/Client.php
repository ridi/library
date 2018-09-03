<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Ridibooks\Store\Library\BasePayload;

class Client
{
    private const DEFAULT_ACCOUNT_SERVER_URI = 'https://library-api.ridibooks.com';
    /** @var Client */
    private $client;

    /**
     * @see GuzzleClient
     * @param array $config
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['base_uri'])) {
            $config['base_uri'] = self::DEFAULT_ACCOUNT_SERVER_URI;
        }
        $this->client = new GuzzleClient($config);
    }

    /**
     * @param BasePayload $payload
     * @return PromiseInterface
     */
    public function sendCommandAsync(BasePayload $payload): PromiseInterface
    {
        $promise = $this->client->requestAsync(
            $payload->getRequestMethod(),
            $payload->getRequestUri(),
            ['json' => $payload,]
        );

        return $promise;
    }

    /**
     * @param BasePayload $payload
     * @return Response
     * @throws \LogicException
     */
    public function sendCommand(BasePayload $payload): Response
    {
        $promise = $this->sendCommandAsync($payload);

        return $promise->wait();
    }
}
