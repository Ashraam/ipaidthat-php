<?php

namespace Ashraam\IpaidthatPhp\Entity;

final class InvoiceItem extends AbstractEntity
{
    public $id;

    public $invoice;

    public $name;

    public $unit_price;

    public $quantity;

    public $tax_percent;

    public $discount_percent;

    public $additional_info;

    public $position;
}
