<?php
declare(strict_types=1);

namespace Ridibooks\Store\Library\AccountCommandApiClient;

use GuzzleHttp\RequestOptions as GuzzleRequestOptions;

final class RequestOptions
{
    public const ALLOW_REDIRECTS = GuzzleRequestOptions::ALLOW_REDIRECTS;
    public const AUTH = GuzzleRequestOptions::AUTH;
    public const BODY = GuzzleRequestOptions::BODY;
    public const CERT = GuzzleRequestOptions::CERT;
    public const COOKIES = GuzzleRequestOptions::COOKIES;
    public const CONNECT_TIMEOUT = GuzzleRequestOptions::CONNECT_TIMEOUT;
    public const DEBUG = GuzzleRequestOptions::DEBUG;
    public const DECODE_CONTENT = GuzzleRequestOptions::DECODE_CONTENT;
    public const DELAY = GuzzleRequestOptions::DELAY;
    public const EXPECT = GuzzleRequestOptions::EXPECT;
    public const FORM_PARAMS = GuzzleRequestOptions::FORM_PARAMS;
    public const HEADERS = GuzzleRequestOptions::HEADERS;
    public const HTTP_ERRORS = GuzzleRequestOptions::HTTP_ERRORS;
    public const JSON = GuzzleRequestOptions::JSON;
    public const MULTIPART = GuzzleRequestOptions::MULTIPART;
    public const ON_HEADERS = GuzzleRequestOptions::ON_HEADERS;
    public const ON_STATS = GuzzleRequestOptions::ON_STATS;
    public const PROGRESS = GuzzleRequestOptions::PROGRESS;
    public const PROXY = GuzzleRequestOptions::PROXY;
    public const QUERY = GuzzleRequestOptions::QUERY;
    public const SINK = GuzzleRequestOptions::SINK;
    public const SYNCHRONOUS = GuzzleRequestOptions::SYNCHRONOUS;
    public const SSL_KEY = GuzzleRequestOptions::SSL_KEY;
    public const STREAM = GuzzleRequestOptions::STREAM;
    public const VERIFY = GuzzleRequestOptions::VERIFY;
    public const TIMEOUT = GuzzleRequestOptions::TIMEOUT;
    public const READ_TIMEOUT = GuzzleRequestOptions::READ_TIMEOUT;
    public const VERSION = GuzzleRequestOptions::VERSION;
    public const FORCE_IP_RESOLVE = GuzzleRequestOptions::FORCE_IP_RESOLVE;

    /**
     * jwt_expiration_time: (int) The amount of time after which JWT will be expired in seconds.
     */
    public const JWT_EXPIRATION_TIME = 'jwt_expiration_time';
}
