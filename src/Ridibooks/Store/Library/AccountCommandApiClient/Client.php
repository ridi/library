<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Ridibooks\Store\Library\AccountCommandApiClient\Payload\BaseCommandPayload;

class Client
{
    private const DEFAULT_ACCOUNT_SERVER_URI = 'https://library-api.ridibooks.com';
    /** @var Client */
    private $client;

    /**
     * @param array $config
     * @see GuzzleClient
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['base_uri'])) {
            $config['base_uri'] = self::DEFAULT_ACCOUNT_SERVER_URI;
        }
        $this->client = new GuzzleClient($config);
    }

    /**
     * @param BaseCommandPayload $payload
     * @return PromiseInterface
     */
    public function sendCommandAsync(BaseCommandPayload $payload): PromiseInterface
    {
        $promise = $this->client->requestAsync(
            $payload->getRequestMethod(),
            $payload->getRequestUri(),
            ['json' => $payload,]
        );

        return $promise;
    }

    /**
     * @param BaseCommandPayload $payload
     * @return Response
     */
    public function sendCommand(BaseCommandPayload $payload): Response
    {
        $promise = $this->sendCommandAsync($payload);

        return $promise->wait();
    }
}
