<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient;

use Firebase\JWT\JWT;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Ridibooks\Store\Library\AccountCommandApiClient\Model\Command\Command;

class Client
{
    public const JWT_EXPIRATION_TIME_OPTION = 'opt: JWT EXP';

    private const DEFAULT_ACCOUNT_SERVER_URI = 'https://library-api.ridibooks.com';

    /** @var Client */
    private $client;
    /** @var string */
    private $jwt_private_key;
    /** @var int */
    private $default_jwt_expiration_time = 300;

    /**
     * @param string $jwt_private_key
     * @param array $config
     * @throws \InvalidArgumentException
     */
    public function __construct(string $jwt_private_key, array $config = [])
    {
        if (!isset($config['base_uri'])) {
            $config['base_uri'] = self::DEFAULT_ACCOUNT_SERVER_URI;
        }
        if (isset($config[self::JWT_EXPIRATION_TIME_OPTION])) {
            $this->default_jwt_expiration_time = $config[self::JWT_EXPIRATION_TIME_OPTION];
            unset($config[self::JWT_EXPIRATION_TIME_OPTION]);
        }
        $this->client = new GuzzleClient($config);
        $this->jwt_private_key = $jwt_private_key;
    }

    /**
     * @param Command $command
     * @param array $options
     * @return PromiseInterface
     */
    public function sendCommandAsync(Command $command, array $options = []): PromiseInterface
    {
        $jwt = $this->createJwt($options[self::JWT_EXPIRATION_TIME_OPTION] ?? $this->default_jwt_expiration_time);

        if (isset($options[self::JWT_EXPIRATION_TIME_OPTION])) {
            unset($options[self::JWT_EXPIRATION_TIME_OPTION]);
        }

        $options[RequestOptions::HEADERS] = ['Authorization' => "Bearer $jwt", 'Accept' => 'application/json'];
        $options[RequestOptions::JSON] = $command;

        return $this->client->requestAsync($command->getRequestMethod(), $command->getRequestUri(), $options);
    }

    /**
     * @param Command $command
     * @param array $options (RequestOptions::X => Y)[]
     * @return Response
     * @throws \LogicException
     */
    public function sendCommand(Command $command, array $options = []): Response
    {
        return $this->sendCommandAsync($command, $options)->wait();
    }

    /**
     * @param int $expiration_time in seconds
     * @return string
     */
    private function createJwt(int $expiration_time): string
    {
        $payload = ['iss' => 'user-book', 'aud' => 'library', 'exp' => time() + $expiration_time];

        return JWT::encode($payload, $this->jwt_private_key, 'RS256');
    }
}
