<?php

namespace Ashraam\IpaidthatPhp\Contracts;

use GuzzleHttp\Client;

interface ApiInterface
{
    public function __construct(Client $client);
}
