<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
class Api
{
    const URI = 'https://www.itccompliance.co.uk/recruitment-webservice/api';
    protected $apiKey;

    public function __construct($apiKey)
    {
        if (!isset($apiKey) or trim($apiKey) == '') {
            throw new Exception("Invalid API key!");
        }
        $this->apiKey = $apiKey;
    }


    /**
     * API calls
     *
     * @param string $url
     * @param array $params
     * @param string $method
     * Make the request through Guzzle, it will attempt to retry if the retryDecider conditions are passed
     * Could have used CURL directly but Guzzle abstracts all the nitty-gritty details away
     * @return mixed
     */
    public function apiCall($url, $params = array(), $method = 'get')
    {
        try {
            $handlerStack = HandlerStack::create(new CurlHandler());
            $handlerStack->push(Middleware::retry($this->retryDecider(), $this->retryDelay()));
            $client = new Client(array(
                'curl'   => array( CURLOPT_SSL_VERIFYPEER => false ),
                'verify' => false,
                'handler' => $handlerStack
            ));
            $res = $client->request($method, self::URI . $url, $params);
            return json_decode($res->getBody());
        } catch (ClientException $e) {
            echo Psr7\str($e->getRequest());
            echo Psr7\str($e->getResponse());
        }

    }


    /**
     * @return Closure
     * this function will determine the conditions on whether or not to retry the http request
     */
    public function retryDecider()
    {
        return function (
            $retries,
            Request $request,
            Response $response = null,
            RequestException $exception = null
        ) {
            // Limit the number of retries to 5
            if ($retries >= 5) {
                return false;
            }

            // Retry connection exceptions
            if ($exception instanceof ConnectException) {
                return true;
            }

            if ($response) {
                $res = json_decode($response->getBody());
                // Retry on server errors - tricky as sometimes fails and returns a 200 so we need to check for the `error` property
                if ($response->getStatusCode() >= 500 || ($response->getStatusCode() == 200 && !empty($res->error) ) ) {
                    return true;
                }
            }

            return false;
        };
    }

    /**
     * delay 1s 2s 3s 4s 5s
     *
     * @return Closure
     */
    public function retryDelay()
    {
        return function ($numberOfRetries) {
            return 1000 * $numberOfRetries;
        };
    }

}