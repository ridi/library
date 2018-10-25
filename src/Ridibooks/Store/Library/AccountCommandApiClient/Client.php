<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient;

use Firebase\JWT\JWT;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\RejectedPromise;
use GuzzleHttp\Psr7\Response;
use Ridibooks\Store\Library\AccountCommandApiClient\Exception\RequestException;
use Ridibooks\Store\Library\AccountCommandApiClient\Model\Command\Command;
use Ridibooks\Store\Library\AccountCommandApiClient\Model\Command\UserCommand;
use Ridibooks\Store\Library\AccountCommandApiClient\Service\LibraryActionService;

class Client
{
    /** @deprecated Use RequestOptions::JWT_EXPIRATION_TIME */
    public const JWT_EXPIRATION_TIME_OPTION = RequestOptions::JWT_EXPIRATION_TIME;

    private const DEFAULT_ACCOUNT_SERVER_URI = 'https://library-api.ridibooks.com';

    /** @var Client */
    private $client;
    /** @var string */
    private $jwt_private_key;

    /** @var array */
    private $default_options = [
        RequestOptions::JWT_EXPIRATION_TIME => 300,
        RequestOptions::RESPONSE_TYPE_B_IDS => false,
    ];

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
        foreach (RequestOptions::LIBRARY_OPTIONS as $library_option_name) {
            if (isset($config[$library_option_name])) {
                $this->default_options[$library_option_name] = $config[$library_option_name];
                unset($config[$library_option_name]);
            }
        }
        $this->client = new GuzzleClient($config);
        $this->jwt_private_key = $jwt_private_key;
    }

    /**
     * @param LibraryAction $library_action
     * @param array $options
     * @return PromiseInterface
     * @throws \InvalidArgumentException
     */
    public function sendLibraryActionAsync(LibraryAction $library_action, array $options = []): PromiseInterface
    {
        try {
            $user_command = LibraryActionService::createCommand($library_action);
        } catch (\Throwable $e) {
            return new RejectedPromise($e);
        }

        return $this->sendCommandAsync($user_command, $options);
    }

    /**
     * @param LibraryAction $library_action
     * @param array $options
     * @return Response
     * @throws RequestException
     * @throws \LogicException
     */
    public function sendLibraryAction(LibraryAction $library_action, array $options = []): Response
    {
        try {
            $user_command = LibraryActionService::createCommand($library_action);
        } catch (\Throwable $e) {
            throw new RequestException($e, null);
        }
        return $this->sendCommand($user_command, $options);
    }

    /**
     * @param Command $command
     * @param array $options (RequestOptions::X => Y)[]
     * @return PromiseInterface
     */
    public function sendCommandAsync(Command $command, array $options = []): PromiseInterface
    {
        $jwt = $this->createJwt($this->getOption($options, RequestOptions::JWT_EXPIRATION_TIME));

        if ($this->getOption($options, RequestOptions::RESPONSE_TYPE_B_IDS)) {
            if ($command instanceof UserCommand) {
                $command->setResponseTypeBids();
            }
            unset($options[RequestOptions::RESPONSE_TYPE_B_IDS]);
        }

        foreach (RequestOptions::LIBRARY_OPTIONS as $library_option_name) {
            if (isset($options[$library_option_name])) {
                unset($options[$library_option_name]);
            }
        }

        $options[RequestOptions::HEADERS] = ['Authorization' => "Bearer $jwt", 'Accept' => 'application/json'];
        $options[RequestOptions::JSON] = $command;

        return $this->client->requestAsync($command->getRequestMethod(), $command->getRequestUri(), $options)
            ->otherwise(
                function (\Exception $e) use ($command) {
                    throw new RequestException($e, $command);
                }
            );
    }

    /**
     * @param Command $command
     * @param array $options
     * @return Response
     * @throws RequestException
     * @throws \LogicException
     */
    public function sendCommand(Command $command, array $options = []): Response
    {
        $options[RequestOptions::SYNCHRONOUS] = true;
        try {
            return $this->sendCommandAsync($command, $options)->wait();
        } catch (RequestException $e) {
            throw $e;
        }
    }

    /**
     * @param array $options
     * @param string $option_name RequestOptions
     * @return mixed
     */
    private function getOption(array $options, string $option_name)
    {
        return $options[$option_name] ?? $this->default_options[$option_name];
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
