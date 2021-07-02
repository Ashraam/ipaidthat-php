<?php

namespace Ashraam\IpaidthatPhp;

use GuzzleHttp\Client;
use InvalidArgumentException;
use GuzzleHttp\ClientInterface;
use Ashraam\IpaidthatPhp\Api\InvoicesApi;
use Ashraam\IpaidthatPhp\Api\CustomersApi;
use Ashraam\IpaidthatPhp\Api\InvoiceItemsApi;

class Ipaidthat
{
    private $client;

    public function __construct($token, Client $client = null)
    {
        if (!is_string($token)) {
            throw new InvalidArgumentException("The token must be a string");
        }

        if ($client) {
            $this->client = $client;
            
            return;
        }

        $this->client = new Client([
            'base_uri' => 'https://ipaidthat.io/inv/api/v2/',
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => "Token {$token}"
            ]
        ]);
    }

    public function customers()
    {
        return new CustomersApi($this->client);
    }

    public function invoices()
    {
        return new InvoicesApi($this->client);
    }

    public function invoiceItems()
    {
        return new InvoiceItemsApi($this->client);
    }
}
