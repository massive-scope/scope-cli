<?php

namespace Scope\Cli\GraphQL;

use GuzzleHttp\Client as GuzzleClient;
use Scope\Cli\Configuration;

class Client
{
    /**
     * @var GuzzleClient
     */
    private $guzzle;

    /**
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->guzzle = new GuzzleClient(
            [
                'base_uri' => 'http://' . $configuration->get('host', '127.0.0.1:8000') . '/graphql',
            ]
        );
    }

    public function query($query, $alias = null)
    {
        $response = $this->guzzle->post('', ['json' => ['query' => $query]]);

        $data = json_decode($response->getBody(), true);
        if ($alias) {
            return $data['data'][$alias];
        }

        return $data['data'];
    }
}
