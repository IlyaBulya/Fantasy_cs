<?php

namespace App\Services;

use GuzzleHttp\Client;

class PandascoreApiService
{
    protected $client;
    protected $baseUrl = 'https://api.pandascore.co';
    protected $apiKey = 'W7oJNVuiJDhZUz0oPMfboq5ZMgW94NmOQKGz9VzRnJPb4QmWii8';

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getLiveMatches()
    {
        try {
            $response = $this->client->request('GET', "{$this->baseUrl}/matches/running", [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Accept' => 'application/json',
                ],
            ]);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            \Log::error("Error fetching live matches: " . $e->getMessage());
            return [];
        }
    }

    public function getNonLiveMatches()
    {
        try {
            $response = $this->client->request('GET', "{$this->baseUrl}/matches/past", [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Accept' => 'application/json',
                ],
            ]);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            \Log::error("Error fetching non-live matches: " . $e->getMessage());
            return [];
        }
    }

    public function getMatchById($id)
    {
        try {
            $response = $this->client->request('GET', "{$this->baseUrl}/matches/{$id}", [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Accept' => 'application/json',
                ],
            ]);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            \Log::error("Error fetching match by ID ({$id}): " . $e->getMessage());
            return null;
        }
    }

    public function getMatchFrames($id)
    {
        try {
            $response = $this->client->request('GET', "{$this->baseUrl}/matches/{$id}/frames", [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Accept' => 'application/json',
                ],
            ]);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            \Log::error("Error fetching match frames: " . $e->getMessage());
            return [];
        }
    }
}
