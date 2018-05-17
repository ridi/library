<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;
use Ridibooks\Store\Library\AccountCommandApiClient\Payload\DeleteCommandPayload;
use Ridibooks\Store\Library\AccountCommandApiClient\Payload\UpdateCommandPayload;

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
     * @param DeleteCommandPayload $payload
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function sendDeleteCommandAsync(DeleteCommandPayload $payload)
    {
        $u_idx = $payload->getUidx();
        $promise = $this->client->requestAsync('POST', "/command/delete/{$u_idx}/", [
            'json' => $payload,
        ]);

        return $promise;
    }

    /**
     * @param DeleteCommandPayload $payload
     * @return Response
     */
    public function sendDeleteCommand(DeleteCommandPayload $payload)
    {
        $promise = $this->sendDeleteCommandAsync($payload);

        return $promise->wait();
    }

    /**
     * @param UpdateCommandPayload $payload
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function sendUpdateCommandAsync(UpdateCommandPayload $payload)
    {
        $u_idx = $payload->getUidx();
        $promise = $this->client->requestAsync('POST', "/command/update/{$u_idx}/", [
            'json' => $payload,
        ]);

        return $promise;
    }

    /**
     * @param UpdateCommandPayload $payload
     * @return Response
     */
    public function sendUpdateCommand(UpdateCommandPayload $payload)
    {
        $promise = $this->sendUpdateCommandAsync($payload);

        return $promise->wait();
    }
}
