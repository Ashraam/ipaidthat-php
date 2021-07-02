<?php

namespace Ashraam\IpaidthatPhp\Tests;

use Ashraam\IpaidthatPhp\Ipaidthat;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase
{
    /** @test */
    public function it_requires_a_token()
    {
        $this->expectException(\ArgumentCountError::class);

        $api = new Ipaidthat();
    }

    /** @test */
    public function the_token_must_be_a_string()
    {
        $this->expectException(\InvalidArgumentException::class);

        $api = new Ipaidthat(['token']);

        $api = new Ipaidthat(123);

        $api = new Ipaidthat(true);
    }

    /** @test */
    public function a_wrong_token_returns_an_error()
    {
        $this->expectException(\GuzzleHttp\Exception\ClientException::class);

        $mock = new MockHandler([
            new Response(401, [], '{"detail":"Token non valide."}'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token');

        $response = $api->customers()->list();
    }
}
