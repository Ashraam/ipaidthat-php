# IPaidThat-PHP

A PHP wrapper for [IPaidThat](https://ipaidthat.io/)'s API (V2).

You can manage customers, invoices, invoice's items.

## Table of contents

- [IPaidThat-PHP](#ipaidthat-php)
  - [Table of contents](#table-of-contents)
  - [Installation](#installation)
  - [Usage](#usage)
    - [List or filter customers](#list-or-filter-customers)
    - [Get a customer](#get-a-customer)
    - [Create a customer](#create-a-customer)
    - [Update a customer](#update-a-customer)
    - [Delete a customer](#delete-a-customer)
    - [List or filter invoices](#list-or-filter-invoices)
    - [Get an invoice](#get-an-invoice)
    - [Create an invoice](#create-an-invoice)
    - [Update an invoice](#update-an-invoice)
    - [Download an invoice](#download-an-invoice)
    - [Validate an invoice](#validate-an-invoice)
    - [Delete an invoice](#delete-an-invoice)
    - [List or filter invoice items](#list-or-filter-invoice-items)
    - [Get an invoice item](#get-an-invoice-item)
    - [Add an item to an invoice](#add-an-item-to-an-invoice)
    - [Update an invoice item](#update-an-invoice-item)
    - [delete an invoice item](#delete-an-invoice-item)
  - [Contributing](#contributing)
  - [License](#license)

---

## Installation

Using composer

```bash
composer require ashraam/ipaidthat-php
```

## Usage

---

### List or filter customers

This method returns an array of customers

```php
use Ashraam\IpaidthatPhp\Ipaidthat;

$api = new Ipaidthat('your_token');

$customers = $api->customers()->list();

// With filters
$customers = $api->customers()->list([
   'last_name' => 'Doe',
   'email' => 'john.doe@gmail.com'
]);
```

___Available filters:___ external_id, name, last_name, first_name, email, siren

Please refer to the official documentation for more informations about types and requirements.

---

### Get a customer

This methods returns a customer

```php
use Ashraam\IpaidthatPhp\Ipaidthat;

$api = new Ipaidthat('your_token');

$customers = $api->customers()->get(123);
```

---

### Create a customer

this methods returns the newly created customer

The method only accept an instance of ```Ashraam\IpaidthatPhp\Entity\Customer```

```php
use Ashraam\IpaidthatPhp\Ipaidthat;
use Ashraam\IpaidthatPhp\Entity\Customer;

$api = new Ipaidthat('your_token');

$customer = $api->customers()->create(new Customer([
   'external_id' => 'string',
   'name' => 'string',
   'first_name' => 'string',
   'last_name' => 'string',
   'siren' => 'string',
   'vat' => 'string',
   'address' => 'string',
   'email' => 'string',
   'phone' => 'phone',
   'extra' => 'string'
]));
```

---

### Update a customer

this methods returns the updated customer

The method only accept an instance of ```Ashraam\IpaidthatPhp\Entity\Customer```

```php
use Ashraam\IpaidthatPhp\Ipaidthat;
use Ashraam\IpaidthatPhp\Entity\Customer;

$api = new Ipaidthat('your_token');

$customer = $api->customers()->get(123);

$customer->first_name = 'Chuck';
$customer->last_name = 'Norris';

$customer = $api->customers()->update($customer);
```

---

### Delete a customer

This methods returns an empty response

```php
use Ashraam\IpaidthatPhp\Ipaidthat;

$api = new Ipaidthat('your_token');

$api->customers()->delete(123);
```

---

### List or filter invoices

This methods returns an array of invoices

```php
use Ashraam\IpaidthatPhp\Ipaidthat;

$api = new Ipaidthat('your_token');

$invoices = $api->invoices()->list();

// With filters
$invoices = $api->invoices()->list([
    'issue_date' => '2021-01-25',
    'customer_id' => 123
])
```

___Available filters :___ external_id, type, status, issue_date, number, generated_number, due_date, sent, customer_id, sender_id, customer, sender.

Please refer to the official documentation for more informations about types and requirements.

---

### Get an invoice

This methods returns an invoice by it's ID (without items)

```php
use Ashraam\IpaidthatPhp\Ipaidthat;

$api = new Ipaidthat('your_token');

$invoice = $api->invoices()->get(750);
```

---

### Create an invoice

This methods returns the newly created invoice

The method only accept an instance of ```Ashraam\IpaidthatPhp\Entity\Invoice```

```php
use Ashraam\IpaidthatPhp\Ipaidthat;

$api = new Ipaidthat('your_token');

$invoice = $api->invoices()->create(new Invoice([
    'external_id' => 'string, nullable',
    'issue_date' => 'Y-m-d',
    'type' => 'invoice|quote|order|credit|other',
    'due_date' => 'Y-m-d',
    'shipping' => 10.5,
    'c_field_name_1' => 'string',
    'c_field_value_1' => 'string',
    'c_field_name_2' => 'string',
    'c_field_value_2' => 'string',
    'sender' => 'integer, nullable',
    'customer' => 'interger, nullable',
    'multi_page' => 'boolean',
    'status' => 'draft|updating|not paid|paid',
    'paid' => 'boolean'
]));
```

---

### Update an invoice

This methods returns the updated invoice

The method only accept an instance of ```Ashraam\IpaidthatPhp\Entity\Invoice```

```php
use Ashraam\IpaidthatPhp\Ipaidthat;

$api = new Ipaidthat('your_token');

$invoice = $api->invoices()->get(123);

$invoice->due_date = '2021-12-15';
$invoice->multi_page = true;

$invoice = $api->invoices()->update($invoice);
```

---

### Download an invoice

This methods returns the string raw content of the PDF

```php
use Ashraam\IpaidthatPhp\Ipaidthat;

$api = new Ipaidthat('your_token');

$contents = $api->invoices()->download(123);

file_put_contents('invoice.pdf', $contents);
```

---

### Validate an invoice

This methods validate an invoice,

if the second parameter is set to true the invoice will be sent to the customer email address (default set to ```false```)

```php
use Ashraam\IpaidthatPhp\Ipaidthat;

$api = new Ipaidthat('your_token');

$invoice = $api->invoices()->validate(123, true);
```

---

### Delete an invoice

This methods returns an empty response

Validated document can't be delete

```php
use Ashraam\IpaidthatPhp\Ipaidthat;

$api = new Ipaidthat('your_token');

$api->invoices()->delete(123);
```

---

### List or filter invoice items

This methods returns an array of InvoiceItem

```php
use Ashraam\IpaidthatPhp\Ipaidthat;

$api = new Ipaidthat('your_token');

$items = $api->invoiceItems()->list();

// With filters
$items = $api->invoiceItems()->list([
    'invoice_id' => 13255
]);
```

___Available filters:___ invoice_id, name, additionnal_info, invoice

---

### Get an invoice item

This methods returns the item by it's ID

```php
use Ashraam\IpaidthatPhp\Ipaidthat;

$api = new Ipaidthat('your_token');

$item = $api->invoiceItems()->get(455874);
```

---

### Add an item to an invoice

This methods returns the newly created item

The method only accept an instance of ```Ashraam\IpaidthatPhp\Entity\InvoiceItem```

```php
use Ashraam\IpaidthatPhp\Ipaidthat;

$api = new Ipaidthat('your_token');

$item = $api->invoiceItems()->create(new InvoiceItem([
    'invoice' => $invoice_id,   // Required
    'name' => 'name',           // Required
    'unit_price' => 12.15       // Required
    'quantity' => 1,
    'tax_percent' => 20,
    'discount_percent' => 5,
    'additionnal_info' => '',
    'position' => 1
]));
```

---

### Update an invoice item

This methods returns the updated item

The method only accept an instance of ```Ashraam\IpaidthatPhp\Entity\InvoiceItem```

```php
use Ashraam\IpaidthatPhp\Ipaidthat;

$api = new Ipaidthat('your_token');

$item = $api->invoiceItems()->get(455874);

$item->name = 'Edited name';
$item->quantity = 6;

$item = $api->invoiceItems()->update($item);
```

---

### delete an invoice item

This methods returns an empty response

```php
use Ashraam\IpaidthatPhp\Ipaidthat;

$api = new Ipaidthat('your_token');

$api->invoiceItems()->delete(455874);
```

---

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](LICENCE.md)