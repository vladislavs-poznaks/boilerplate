<?php

declare(strict_types=1);

namespace App\Services\Emailable;

use App\Config;
use GuzzleHttp\Client;

class EmailableService
{
    private string $apiKey;
    private string $baseUrl;

    public function __construct(Config $config)
    {
        $this->apiKey = $config->services['emailable']['apiKey'];
        $this->baseUrl = $config->services['emailable']['baseUrl'];
    }

    public function verify(string $email): array
    {
        $client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 5
        ]);

        $params = [
            'api_key' => $this->apiKey,
            'email' => $email
        ];

        $response = $client->get('verify?' . http_build_query($params));

        return json_decode($response->getBody()->getContents(), true);
    }
}