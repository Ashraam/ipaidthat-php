<?php

namespace Ashraam\IpaidthatPhp\Api;

use Ashraam\IpaidthatPhp\Contracts\ApiInterface;
use GuzzleHttp\Client;

abstract class AbstractApi implements ApiInterface
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
