<?php

namespace Scope\Cli\GraphQL;

use GuzzleHttp\Client as GuzzleClient;

class Client
{
    /**
     * @var GuzzleClient
     */
    private $guzzle;

    /**
     */
    public function __construct()
    {
        $this->guzzle = new GuzzleClient(
            [
                'base_uri' => 'http://127.0.0.1:8000/graphql',
            ]
        );
    }

    public function query($query, $alias = null)
    {
        $respone = $this->guzzle->post('', ['json' => ['query' => $query]]);

        $data = json_decode($respone->getBody(), true);
        if ($alias) {
            return $data['data'][$alias];
        }

        return $data['data'];
    }
}
