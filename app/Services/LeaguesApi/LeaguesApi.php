<?php

namespace App\Services\LeaguesApi;

use GuzzleHttp\Client;

class LeaguesApi
{
    private $config;

    /** @var Client */
    private $client;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->client = new LeaguesApiClient($config);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface|string|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getData()
    {
        return $this->client->get($this->config['urls']['leagues_list']);
    }

    public function getLeaguesIds(): array
    {
        $data = $this->getData();

        $leaguesIds = [];
        foreach ($data->infos as $league) {
            $leaguesIds[] = $league->league_id;
        }

        return $leaguesIds;
    }

    public function getLeagueById(int $leagueId)
    {
        $data = $this->getData();

        foreach ($data->infos as $league) {
            if ($leagueId === (int)$league->league_id) {
                return $league;
            }
        }

        return null;
    }

    public function getLeaguesIdsByDate(int $timestamp)
    {
        $data = $this->getData();

        $leaguesIds = [];
        foreach ($data->infos as $league) {
            if (!($timestamp > (int)$league->start_timestamp)) {
                continue;
            }
            $leaguesIds[] = $league->league_id;
        }
        return $leaguesIds;
    }
}
