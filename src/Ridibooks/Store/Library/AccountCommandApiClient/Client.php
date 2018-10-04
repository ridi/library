<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Ridibooks\Store\Library\AccountCommandApiClient\Payload\Payload;

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
     * @param Payload $payload
     * @param array $options (RequestOptions::X => Y)[]
     * @return PromiseInterface
     */
    public function sendCommandAsync(Payload $payload, array $options = []): PromiseInterface
    {
        $options[RequestOptions::JSON] = $payload;

        return $this->client->requestAsync($payload->getRequestMethod(), $payload->getRequestUri(), $options);
    }

    /**
     * @param Payload $payload
     * @param array $options (RequestOptions::X => Y)[]
     * @return Response
     * @throws \LogicException
     */
    public function sendCommand(Payload $payload, array $options = []): Response
    {
        return $this->sendCommandAsync($payload, $options)->wait();
    }
}
