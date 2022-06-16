<?php

namespace App\Services\LeaguesApi;

use GuzzleHttp\Client;

class LeaguesApiClient
{
    private $config;

    /** @var Client */
    private $client;

    public function __construct($config)
    {
        $this->config = $config;

        $this->createClient();
    }

    /**
     * Create client
     */
    private function createClient()
    {
        $this->client = new Client([
            'base_uri' => $this->config['host'],
            'verify' => false,
        ]);
    }

    /**
     * @param $uri
     * @param $data
     * @return string|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($uri, $data)
    {
        return $this->request('POST', $uri, ['body' => $data]);
    }

    /**
     * @param $uri
     * @param $data
     * @return string|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($uri, $data = null)
    {
        return $this->request('GET', $uri, ['body' => $data]);
    }

    /**
     * @param $method
     * @param $uri
     * @param array $options
     * @return string|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($method, $uri, $options = [])
    {
        $request = $this->client->request($method, $uri, $options);

        return json_decode($request->getBody()->getContents());
    }
}
