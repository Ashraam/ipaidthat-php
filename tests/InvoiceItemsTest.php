<?php

namespace Ashraam\IpaidthatPhp\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Ashraam\IpaidthatPhp\Ipaidthat;
use GuzzleHttp\Handler\MockHandler;
use Ashraam\IpaidthatPhp\Entity\InvoiceItem;
use Ashraam\IpaidthatPhp\Api\InvoiceItemsApi;

class InvoiceItemsTest extends TestCase
{
    /** @test */
    public function it_returns_an_instance_of_InvoiceItemsApi()
    {
        $api = new Ipaidthat('my_token');

        $items = $api->invoiceItems();

        $this->assertInstanceOf(InvoiceItemsApi::class, $items);
    }


    /** @test */
    public function a_invoiceItem_instance_is_required_to_create_or_update_an_item()
    {
        $this->expectException(\TypeError::class);

        $api = new Ipaidthat('my_token');

        $items = $api->invoiceItems()->create([]);
        $items = $api->invoiceItems()->update([]);
    }


    /** @test */
    public function it_can_list_items()
    {
        $mock = new MockHandler([
            new Response(200, [], '[{"id":1,"invoice":1,"name":"Item","additional_info":"info","unit_price":10.5,"quantity":2,"tax_percent":20,"discount_percent":0,"position":1}]')
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $items = $api->invoiceItems()->list();

        $this->assertCount(1, $items);
        $this->assertInstanceOf(InvoiceItem::class, $items[0]);
        $this->assertSame($items[0]->id, 1);
        $this->assertSame($items[0]->name, 'Item');
    }


    /** @test */
    public function it_can_get_an_item()
    {
        $mock = new MockHandler([
            new Response(200, [], '{"id":1,"invoice":1,"name":"Item","additional_info":"info","unit_price":10.5,"quantity":2,"tax_percent":20,"discount_percent":0,"position":1}')
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $item = $api->invoiceItems()->get(1);

        $this->assertInstanceOf(InvoiceItem::class, $item);
        $this->assertSame($item->id, 1);
        $this->assertSame($item->name, 'Item');
    }


    /** @test */
    public function it_can_add_an_item_to_an_invoice()
    {
        $mock = new MockHandler([
            new Response(200, [], '{"id":1,"invoice":1,"name":"Item","additional_info":"info","unit_price":10.5,"quantity":2,"tax_percent":20,"discount_percent":0,"position":1}')
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $item = $api->invoiceItems()->create(new InvoiceItem([
            'invoice' => 1,
            'name' => 'Item',
            'unit_price' => 10.5
        ]));

        $this->assertInstanceOf(InvoiceItem::class, $item);
        $this->assertSame($item->id, 1);
        $this->assertSame($item->name, 'Item');
    }


    /** @test */
    public function it_requires_invoice_id_to_add_an_item()
    {
        $this->expectException(\Exception::class);

        $mock = new MockHandler([
            new Response(400, [], '{"invoice":["Ce champ est obligatoire."],"name":["Ce champ est obligatoire."],"unit_price":["Ce champ est obligatoire."]}')
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $item = $api->invoiceItems()->create(new InvoiceItem([]));
    }


    /** @test */
    public function it_requires_a_name_id_to_add_an_item()
    {
        $this->expectException(\Exception::class);

        $mock = new MockHandler([
            new Response(400, [], '{"invoice":["Ce champ est obligatoire."],"name":["Ce champ est obligatoire."],"unit_price":["Ce champ est obligatoire."]}')
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $item = $api->invoiceItems()->create(new InvoiceItem([]));
    }

    /** @test */
    public function it_requires_a_unit_price_id_to_add_an_item()
    {
        $this->expectException(\Exception::class);

        $mock = new MockHandler([
            new Response(400, [], '{"invoice":["Ce champ est obligatoire."],"name":["Ce champ est obligatoire."],"unit_price":["Ce champ est obligatoire."]}')
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $item = $api->invoiceItems()->create(new InvoiceItem([]));
    }

    /** @test */
    public function it_can_update_an_item()
    {
        $mock = new MockHandler([
            new Response(200, [], '{"id":1,"invoice":1,"name":"Item","additional_info":"info","unit_price":10.5,"quantity":2,"tax_percent":20,"discount_percent":0,"position":1}'),
            new Response(200, [], '{"id":1,"invoice":1,"name":"Updated Item","additional_info":"info","unit_price":10.5,"quantity":2,"tax_percent":20,"discount_percent":0,"position":1}'),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $item = $api->invoiceItems()->get(1);

        $this->assertInstanceOf(InvoiceItem::class, $item);
        $this->assertSame($item->id, 1);
        $this->assertSame($item->name, 'Item');

        $item->name = 'Updated Item';

        $item = $api->invoiceItems()->update($item);

        $this->assertInstanceOf(InvoiceItem::class, $item);
        $this->assertSame($item->id, 1);
        $this->assertSame($item->name, 'Updated Item');
    }

    /** @test */
    public function it_can_delete_an_item()
    {
        $mock = new MockHandler([
            new Response(204, []),
            new Response(404, [], '{"detail":"Pas trouvé."}')
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new Ipaidthat('my_token', $client);

        $response = $api->invoiceItems()->delete(1);
        
        $this->assertNull($response);

        $this->expectException(\Exception::class);

        $api->invoiceItems()->get(1);
    }
}
