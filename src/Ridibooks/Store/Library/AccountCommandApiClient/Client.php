<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;
use Ridibooks\Store\Library\AccountCommandApiClient\Payload\BaseCommandPayload;

class Client
{
    /** @var Client */
    private $client;

    /**
     * @param array $config
     * @see GuzzleClient
     */
    public function __construct(array $config = [])
    {
        if (!array_key_exists('base_uri', $config)) {
            $config['base_uri'] = 'https://library-api.ridibooks.com';
        }
        $this->client = new GuzzleClient($config);
    }

    /**
     * @param BaseCommandPayload $payload
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function sendCommandAsync(BaseCommandPayload $payload)
    {
        $promise = $this->client->requestAsync('POST', $payload->getRequestUri(), [
            'json' => $payload,
        ]);

        return $promise;
    }

    /**
     * @param BaseCommandPayload $payload
     * @return Response
     */
    public function sendCommand(BaseCommandPayload $payload)
    {
        $promise = $this->sendCommandAsync($payload);

        return $promise->wait();
    }
}
