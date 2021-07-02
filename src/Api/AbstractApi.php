<?php

namespace Ashraam\IpaidthatPhp\Api;

use GuzzleHttp\Client;
use Ashraam\IpaidthatPhp\Contracts\ApiInterface;

abstract class AbstractApi implements ApiInterface
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
