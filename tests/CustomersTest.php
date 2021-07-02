<?php

namespace Ashraam\IpaidthatPhp\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Ashraam\IpaidthatPhp\Ipaidthat;
use GuzzleHttp\Handler\MockHandler;
use Ashraam\IpaidthatPhp\Entity\Customer;
use Ashraam\IpaidthatPhp\Api\CustomersApi;

class CustomersTest extends TestCase
{
    /** @test */
    public function it_returns_an_instance_of_CustomerApi()
    {
        $api = new Ipaidthat('my_token');

        $customers = $api->customers();

        $this->assertInstanceOf(CustomersApi::class, $customers);
    }

    /** @test */
    public function a_customer_instance_is_required_to_create_or_update_a_customer()
    {
        $this->expectException(\TypeError::class);

        $api = new Ipaidthat('my_token');

        $customer = $api->customers()->create([]);
        $customer = $api->customers()->update([]);
    }


    /** @test */
    public function it_can_list_customers()
    {
        $mock = new MockHandler([
            new Response(200, [], '[{"id":1,"created":"2021-07-01T06:58:31Z","external_id":"999","name":"","first_name":"John","last_name":"Doe","siren":"","vat":"","address":"","email":"john.doe@gmail.com","phone":"","extra":""}]')
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $customers = $api->customers()->list();

        $this->assertCount(1, $customers);
        $this->assertInstanceOf(Customer::class, $customers[0]);
        $this->assertSame($customers[0]->email, 'john.doe@gmail.com');
    }

    /** @test */
    public function it_can_get_customer()
    {
        $mock = new MockHandler([
            new Response(200, [], '{"id":1,"created":"2021-07-01T06:58:31Z","external_id":"999","name":"","first_name":"John","last_name":"Doe","siren":"","vat":"","address":"","email":"john.doe@gmail.com","phone":"","extra":""}')
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $customer = $api->customers()->get(1);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertSame($customer->id, 1);
        $this->assertSame($customer->email, 'john.doe@gmail.com');
    }

    /** @test */
    public function it_can_create_a_new_customer()
    {
        $mock = new MockHandler([
            new Response(201, [], '{"id":1,"created":"2021-07-01T06:58:31Z","external_id":"999","name":"","first_name":"John","last_name":"Doe","siren":"","vat":"","address":"","email":"john.doe@gmail.com","phone":"","extra":""}')
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $customer = $api->customers()->create(new Customer([]));

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertSame($customer->id, 1);
        $this->assertSame($customer->email, 'john.doe@gmail.com');
    }

    /** @test */
    public function it_can_update_a_customer()
    {
        $mock = new MockHandler([
            new Response(200, [], '{"id":1,"created":"2021-07-01T06:58:31Z","external_id":"999","name":"","first_name":"John","last_name":"Doe","siren":"","vat":"","address":"","email":"john.doe@gmail.com","phone":"","extra":""}'),
            new Response(200, [], '{"id":1,"created":"2021-07-01T06:58:31Z","external_id":"999","name":"","first_name":"John","last_name":"Doe","siren":"","vat":"","address":"","email":"test@test.com","phone":"","extra":"extra"}'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $customer = $api->customers()->get(1);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertSame($customer->id, 1);
        $this->assertSame($customer->email, 'john.doe@gmail.com');

        $customer->email = 'test@test.com';
        $customer->extra = 'extra';

        $customer = $api->customers()->update($customer);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertSame($customer->id, 1);
        $this->assertSame($customer->email, 'test@test.com');
        $this->assertSame($customer->extra, 'extra');
    }

    /** @test */
    public function it_can_delete_a_customer()
    {
        $mock = new MockHandler([
            new Response(204, []),
            new Response(404, [], '{"detail":"Pas trouvé."}')
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $response = $api->customers()->delete(1);

        $this->assertNull($response);

        $this->expectException(\Exception::class);

        $api->invoices()->get(2);
    }
}
