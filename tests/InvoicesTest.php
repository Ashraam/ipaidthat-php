<?php

namespace Ashraam\IpaidthatPhp\Tests;

use Ashraam\IpaidthatPhp\Api\InvoicesApi;
use Ashraam\IpaidthatPhp\Entity\Invoice;
use Ashraam\IpaidthatPhp\Ipaidthat;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class InvoicesTest extends TestCase
{
    /** @test */
    public function it_returns_an_instance_of_InvoicesApi()
    {
        $api = new Ipaidthat('my_token');

        $invoices = $api->invoices();

        $this->assertInstanceOf(InvoicesApi::class, $invoices);
    }

    /** @test */
    public function a_invoice_instance_is_required_to_create_or_update_an_invoice()
    {
        $this->expectException(\TypeError::class);

        $api = new Ipaidthat('my_token');

        $invoice = $api->invoices()->create([]);
        $invoice = $api->invoices()->update([]);
    }

    /** @test */
    public function it_can_list_invoices()
    {
        $mock = new MockHandler([
            new Response(200, [], '[{"id":1,"external_id":"string","issue_date":"2021-07-01","type":"invoice","invoice_number":"","due_date":"2021-07-01","shipping":0,"c_field_name_1":"","c_field_value_1":"","c_field_name_2":"","c_field_value_2":"","sender":0,"customer":0,"draft":true,"multi_page":true,"status":"draft","paid":true}]'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $invoices = $api->invoices()->list();

        $this->assertCount(1, $invoices);
        $this->assertInstanceOf(Invoice::class, $invoices[0]);
        $this->assertSame($invoices[0]->id, 1);
        $this->assertSame($invoices[0]->type, 'invoice');
    }

    /** @test */
    public function it_can_get_an_invoice()
    {
        $mock = new MockHandler([
            new Response(200, [], '{"id":1,"external_id":"string","issue_date":"2021-07-01","type":"invoice","invoice_number":"","due_date":"2021-07-01","shipping":0,"c_field_name_1":"","c_field_value_1":"","c_field_name_2":"","c_field_value_2":"","sender":0,"customer":0,"draft":true,"multi_page":true,"status":"draft","paid":true}'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $invoice = $api->invoices()->get(1);

        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertSame($invoice->id, 1);
        $this->assertSame($invoice->type, 'invoice');
    }

    /** @test */
    public function it_can_create_an_invoice()
    {
        $mock = new MockHandler([
            new Response(201, [], '{"id":2,"external_id":"string","issue_date":"2021-07-01","type":"invoice","invoice_number":"","due_date":"2021-07-01","shipping":0,"c_field_name_1":"","c_field_value_1":"","c_field_name_2":"","c_field_value_2":"","sender":0,"customer":0,"draft":true,"multi_page":true,"status":"draft","paid":true}'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $invoice = $api->invoices()->create(new Invoice([]));

        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertSame($invoice->id, 2);
        $this->assertSame($invoice->type, 'invoice');
    }

    /** @test */
    public function it_can_update_an_invoice()
    {
        $mock = new MockHandler([
            new Response(200, [], '{"id":2,"external_id":"string","issue_date":"2021-07-01","type":"invoice","invoice_number":"","due_date":"2021-07-01","shipping":0,"c_field_name_1":"","c_field_value_1":"","c_field_name_2":"","c_field_value_2":"","sender":0,"customer":0,"draft":true,"multi_page":true,"status":"draft","paid":true}'),
            new Response(200, [], '{"id":2,"external_id":"string","issue_date":"2021-07-01","type":"invoice","invoice_number":"","due_date":"2021-07-01","shipping":35,"c_field_name_1":"","c_field_value_1":"","c_field_name_2":"","c_field_value_2":"","sender":0,"customer":0,"draft":true,"multi_page":true,"status":"paid","paid":true}'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $invoice = $api->invoices()->get(2);

        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertSame($invoice->shipping, 0);
        $this->assertSame($invoice->status, 'draft');

        $invoice->status = 'paid';
        $invoice->shipping = 35;

        $invoice = $api->invoices()->update($invoice);

        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertSame($invoice->shipping, 35);
        $this->assertSame($invoice->status, 'paid');
    }

    /** @test */
    public function it_can_validate_an_invoice()
    {
        $mock = new MockHandler([
            new Response(201, [], '{"send_email":false}'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $response = $api->invoices()->validate(2);

        $this->assertArrayHasKey('send_email', $response);
        $this->assertIsBool($response['send_email']);
    }

    /** @test */
    public function it_can_delete_an_invoice()
    {
        $mock = new MockHandler([
            new Response(204, []),
            new Response(404, [], '{"detail":"Pas trouvé."}'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $response = $api->invoices()->delete(2);

        $this->assertNull($response);

        $this->expectException(\Exception::class);

        $api->invoices()->get(2);
    }
}
